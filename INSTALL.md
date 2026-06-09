# NPU Stress Test インストール手順書

Intel NPU（Core Ultra / Meteor Lake 以降）向け負荷テスト `npu_stress.py` のセットアップ手順。

## 1. 前提環境

| 項目 | 要件 |
| --- | --- |
| CPU | Intel Core Ultra (Meteor Lake) 以降の NPU 内蔵モデル |
| OS  | Windows 11 (22H2 以降) / Ubuntu 22.04 以降 |
| Python | 3.9 – 3.12 |
| メモリ | 8 GB 以上推奨（high レベル実行時） |

## 2. NPU ドライバの導入

### Windows 11
1. 「設定」→「Windows Update」を最新化。
2. Intel 公式の **Intel NPU Driver** を取得しインストール。
   - https://www.intel.com/content/www/us/en/download/794734/intel-npu-driver-windows.html
3. デバイスマネージャーで「ニューラル プロセッサ」→「Intel(R) AI Boost」が表示されることを確認。

### Ubuntu 22.04 / 24.04
```bash
# 最新のリリース版 .deb を入手 (例: v1.10.x)
wget https://github.com/intel/linux-npu-driver/releases/latest/download/intel-driver-compiler-npu_*.deb
wget https://github.com/intel/linux-npu-driver/releases/latest/download/intel-fw-npu_*.deb
wget https://github.com/intel/linux-npu-driver/releases/latest/download/intel-level-zero-npu_*.deb

sudo dpkg -i intel-driver-compiler-npu_*.deb \
             intel-fw-npu_*.deb \
             intel-level-zero-npu_*.deb

# /dev/accel/accel0 へのアクセス権を付与
sudo usermod -a -G render $USER
# 再ログイン or 再起動
```

確認:
```bash
ls /dev/accel/accel0
```

## 3. リポジトリの取得

```bash
git clone https://github.com/trans-ken/checkin_app.git
cd checkin_app
git checkout claude/loving-noether-fi2ntq
```

## 4. Python 環境の構築

```bash
python -m venv .venv
# Windows
.venv\Scripts\activate
# Linux
source .venv/bin/activate

pip install --upgrade pip
pip install openvino>=2024.4 numpy
```

`openvino` 2024.4 以降が NPU プラグインを同梱しています。

## 5. 動作確認

デバイス一覧に `NPU` が出ることを確認:
```bash
python -c "import openvino as ov; print(ov.Core().available_devices)"
# 期待出力: ['CPU', 'GPU', 'NPU']
```

`NPU` が出ない場合はドライバ導入をやり直してください。

## 6. 実行

```bash
# 軽負荷 (30秒)
python npu_stress.py --level low --seconds 30

# 中負荷
python npu_stress.py --level medium --seconds 60

# 高負荷 (NPUフル稼働)
python npu_stress.py --level high --seconds 120
```

オプション:
| 引数 | 既定値 | 説明 |
| --- | --- | --- |
| `--level` | `medium` | `low` / `medium` / `high` |
| `--seconds` | `30` | 実行時間（秒） |
| `--device` | `NPU` | `CPU` / `GPU` / `NPU` |

## 7. NPU 使用率の確認

- **Windows**: タスクマネージャー →「パフォーマンス」→「NPU」
- **Linux**: `intel_npu_top` もしくは `sudo cat /sys/class/accel/accel0/device/npu_busy_time_us` を周期的に観測

## 8. トラブルシューティング

| 症状 | 対処 |
| --- | --- |
| `NPU` がデバイス一覧に出ない | ドライバ未導入。手順 2 を再実施 |
| `RuntimeError: Failed to create NPU device` | ドライバとファームのバージョン不一致。`.deb` 3点を同一リリースで再導入 |
| Linux で permission denied | `render` グループ未参加。再ログイン |
| 起動後 CPU にフォールバックする | OpenVINO のバージョンが古い。`pip install -U openvino` |
| `high` で OOM | `--level medium` に下げる |

## 9. アンインストール

```bash
deactivate
rm -rf .venv
# Ubuntu の場合
sudo apt remove intel-driver-compiler-npu intel-fw-npu intel-level-zero-npu
```
