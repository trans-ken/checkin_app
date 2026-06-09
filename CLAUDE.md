# Intel NPU アプリ開発の知見

`npu_stress.py` 開発で得た、Intel NPU (Core Ultra / Meteor Lake 以降) を OpenVINO から叩く際の実践知メモ。

## 環境構築の落とし穴

- **Windows の `python` は罠**: 未インストールだと Microsoft Store ショートカットに飛ぶ。`winget install --id Python.Python.3.12 -e` で入れて PowerShell を再起動。インストール後も Store に飛ぶ場合は「設定 → アプリ実行エイリアス」で `python.exe` をオフ。
- **PowerShell の venv 有効化**: `.\.venv\Scripts\Activate.ps1`。`UnauthorizedAccess` で弾かれたら `Set-ExecutionPolicy -Scope CurrentUser RemoteSigned`。
- **Linux NPU ドライバ**: `intel-driver-compiler-npu` / `intel-fw-npu` / `intel-level-zero-npu` の3点を **同一リリース** で揃える。`/dev/accel/accel0` に `render` グループでアクセス。
- **Windows NPU ドライバ**: デバイスマネージャーで「Intel(R) AI Boost」表示が成功サイン。

## OpenVINO API バージョン差

- **2026.x で `openvino.runtime` 廃止**: `from openvino.runtime import opset13` ではなく `from openvino import opset13` を使う。
- `core.compile_model(model, "NPU", {"PERFORMANCE_HINT": "THROUGHPUT"})` が定番。`LATENCY` だと並列度が落ちる。
- `available_devices` に `NPU` が出ない場合はドライバ未導入。**サイレントに CPU フォールバック** する作りにしておくと、サンドボックスや CI でも動作確認できる。

## NPU で負荷をかける勘所

- **モデル合成で十分**: `opset13` で Parameter / MatMul / Convolution / ReLU を積めばダミーモデルが作れる。学習済みモデル不要。
- **負荷を上げる軸は3つ**:
  1. モデルサイズ（チャネル数・層数）
  2. 並列推論本数（`create_infer_request()` を複数スレッドから回す）
  3. ループ間スリープ（負荷低めにしたい時だけ入れる）
- **NPU は INT8/FP16 が本領**。FP32 のままだと CPU/GPU と比べた優位性が出にくいが、負荷をかけるだけなら FP32 で十分。
- **Conv の方が NPU 使用率を稼ぎやすい**。MatMul 単体だと VPU 側の利用率が伸びにくい場面がある。

## 動作確認の手段

- **Windows**: タスクマネージャー → パフォーマンス → **NPU** タブで使用率がリアルタイムに見える。
- **Linux**: `intel_npu_top` か `/sys/class/accel/accel0/device/npu_busy_time_us` を周期サンプリング。

## 開発時のテンプレ

```python
import openvino as ov
from openvino import opset13 as ops
import numpy as np

core = ov.Core()
assert "NPU" in core.available_devices, core.available_devices

x = ops.parameter([1, 64, 224, 224], dtype=np.float32, name="x")
w = ops.constant(np.random.randn(128, 64, 3, 3).astype(np.float32))
y = ops.convolution(x, w, [1, 1], [1, 1], [1, 1], [1, 1])
model = ov.Model([y], [x])

compiled = core.compile_model(model, "NPU", {"PERFORMANCE_HINT": "THROUGHPUT"})
req = compiled.create_infer_request()
req.infer({0: np.random.randn(1, 64, 224, 224).astype(np.float32)})
```

## 参考リンク

- Intel NPU Driver (Windows): https://www.intel.com/content/www/us/en/download/794734/intel-npu-driver-windows.html
- Linux NPU Driver: https://github.com/intel/linux-npu-driver
- OpenVINO NPU device docs: https://docs.openvino.ai/2024/openvino-workflow/running-inference/inference-devices-and-modes/npu-device.html
