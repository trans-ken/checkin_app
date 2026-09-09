"""
Intel NPU stress test.

Intel CPU (Core Ultra / Meteor Lake 以降) に搭載されている NPU を
OpenVINO の "NPU" デバイス経由で推論ループにかけ、負荷を発生させる。

3段階の負荷レベル:
    low    : 小さい MatMul モデル + 並列推論 1 本 + 軽いスリープ
    medium : 中規模 Conv モデル + 並列推論 2 本 + スリープなし
    high   : 大きい Conv + MatMul モデル + 並列推論 4 本 + バースト連射

使い方:
    python npu_stress.py --level high --seconds 60

要件:
    pip install openvino numpy
    Intel NPU ドライバが入っていること (Windows / Linux)
"""

import argparse
import time
import threading

import numpy as np
import openvino as ov
from openvino import opset13 as ops


def build_model(level: str) -> ov.Model:
    """負荷レベルに応じた合成モデルを構築する。"""
    if level == "low":
        n, k, m = 1, 512, 512
        x = ops.parameter([n, k], dtype=np.float32, name="x")
        w = ops.constant(np.random.randn(k, m).astype(np.float32))
        y = ops.matmul(x, w, transpose_a=False, transpose_b=False)
        for _ in range(4):
            w2 = ops.constant(np.random.randn(m, m).astype(np.float32))
            y = ops.matmul(y, w2, False, False)
            y = ops.relu(y)
        return ov.Model([y], [x], "npu_low")

    if level == "medium":
        n, c, h, w_ = 1, 32, 128, 128
        x = ops.parameter([n, c, h, w_], dtype=np.float32, name="x")
        y = x
        ch = c
        for _ in range(8):
            kernel = ops.constant(np.random.randn(64, ch, 3, 3).astype(np.float32))
            y = ops.convolution(
                y, kernel,
                strides=[1, 1], pads_begin=[1, 1], pads_end=[1, 1], dilations=[1, 1],
            )
            y = ops.relu(y)
            ch = 64
        return ov.Model([y], [x], "npu_medium")

    # high
    n, c, h, w_ = 1, 64, 224, 224
    x = ops.parameter([n, c, h, w_], dtype=np.float32, name="x")
    y = x
    ch = c
    for _ in range(16):
        kernel = ops.constant(np.random.randn(128, ch, 3, 3).astype(np.float32))
        y = ops.convolution(
            y, kernel,
            strides=[1, 1], pads_begin=[1, 1], pads_end=[1, 1], dilations=[1, 1],
        )
        y = ops.relu(y)
        ch = 128
    y = ops.reduce_mean(y, ops.constant([2, 3], dtype=np.int64), keep_dims=False)
    fc = ops.constant(np.random.randn(128, 1000).astype(np.float32))
    y = ops.matmul(y, fc, False, False)
    return ov.Model([y], [x], "npu_high")


LEVEL_CONFIG = {
    # (並列推論本数, 1ループあたりのバッチ反復回数, ループ後スリープ秒)
    "low":    (1, 1, 0.01),
    "medium": (2, 2, 0.0),
    "high":   (4, 8, 0.0),
}


def run_worker(compiled: ov.CompiledModel, input_shape, stop_at: float,
               burst: int, sleep_s: float, counter: list, idx: int):
    req = compiled.create_infer_request()
    data = np.random.randn(*input_shape).astype(np.float32)
    local = 0
    while time.time() < stop_at:
        for _ in range(burst):
            req.infer({0: data})
            local += 1
        if sleep_s:
            time.sleep(sleep_s)
    counter[idx] = local


def main():
    p = argparse.ArgumentParser()
    p.add_argument("--level", choices=["low", "medium", "high"], default="medium",
                   help="NPU 負荷レベル (3段階)")
    p.add_argument("--seconds", type=int, default=30, help="実行秒数")
    p.add_argument("--device", default="NPU", help="OpenVINO デバイス名")
    args = p.parse_args()

    core = ov.Core()
    available = core.available_devices
    print(f"[info] available devices: {available}")
    if args.device not in available:
        print(f"[warn] {args.device} が見つかりません。CPU にフォールバックします。")
        args.device = "CPU"

    print(f"[info] building model for level={args.level} ...")
    model = build_model(args.level)
    input_shape = list(model.inputs[0].get_shape())

    print(f"[info] compiling for {args.device} ...")
    t0 = time.time()
    compiled = core.compile_model(model, args.device, {
        "PERFORMANCE_HINT": "THROUGHPUT",
    })
    print(f"[info] compile took {time.time() - t0:.2f}s")

    n_workers, burst, sleep_s = LEVEL_CONFIG[args.level]
    print(f"[info] workers={n_workers} burst={burst} sleep={sleep_s}s "
          f"duration={args.seconds}s")

    stop_at = time.time() + args.seconds
    counters = [0] * n_workers
    threads = [
        threading.Thread(
            target=run_worker,
            args=(compiled, input_shape, stop_at, burst, sleep_s, counters, i),
        )
        for i in range(n_workers)
    ]
    t_start = time.time()
    for t in threads:
        t.start()
    for t in threads:
        t.join()
    elapsed = time.time() - t_start

    total = sum(counters)
    print(f"[done] level={args.level} device={args.device} "
          f"inferences={total} elapsed={elapsed:.2f}s "
          f"throughput={total / elapsed:.1f} infer/s")


if __name__ == "__main__":
    main()
