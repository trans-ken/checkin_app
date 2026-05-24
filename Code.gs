/**
 * イラスト入りQRコード生成アプリ (Google Apps Script Web App)
 *
 * - doGet: Webアプリのエントリーポイント。index.html を返す
 * - saveQrToDrive: フロントエンドから渡された PNG (DataURL) を Drive に保存
 * - listSavedQrs: 保存済み QR コードを一覧取得
 */

const FOLDER_NAME = 'QRコード生成';

function doGet() {
  return HtmlService.createTemplateFromFile('index')
    .evaluate()
    .setTitle('イラスト入りQRコード生成')
    .addMetaTag('viewport', 'width=device-width, initial-scale=1')
    .setXFrameOptionsMode(HtmlService.XFrameOptionsMode.ALLOWALL);
}

function include(filename) {
  return HtmlService.createHtmlOutputFromFile(filename).getContent();
}

function getOrCreateFolder_() {
  const folders = DriveApp.getFoldersByName(FOLDER_NAME);
  if (folders.hasNext()) return folders.next();
  return DriveApp.createFolder(FOLDER_NAME);
}

/**
 * Drive に PNG として保存する。
 * @param {string} dataUrl - "data:image/png;base64,..." 形式
 * @param {string} filename - 拡張子なしのファイル名
 * @return {{id:string,name:string,url:string,folderUrl:string}}
 */
function saveQrToDrive(dataUrl, filename) {
  if (!dataUrl || dataUrl.indexOf('data:image/png;base64,') !== 0) {
    throw new Error('PNG データが正しくありません。');
  }
  const safeName = String(filename || 'qrcode')
    .replace(/[\\/:*?"<>|]/g, '_')
    .slice(0, 80) || 'qrcode';

  const base64 = dataUrl.split(',')[1];
  const bytes = Utilities.base64Decode(base64);
  const blob = Utilities.newBlob(bytes, 'image/png', safeName + '.png');

  const folder = getOrCreateFolder_();
  const file = folder.createFile(blob);

  return {
    id: file.getId(),
    name: file.getName(),
    url: file.getUrl(),
    folderUrl: folder.getUrl()
  };
}

/**
 * 保存済み QR コード一覧を返す (新しい順、最大 50 件)。
 */
function listSavedQrs() {
  const folder = getOrCreateFolder_();
  const iter = folder.getFiles();
  const out = [];
  while (iter.hasNext()) {
    const f = iter.next();
    out.push({
      id: f.getId(),
      name: f.getName(),
      url: f.getUrl(),
      thumbnail: 'https://drive.google.com/thumbnail?id=' + f.getId() + '&sz=w200',
      created: f.getDateCreated().toISOString()
    });
  }
  out.sort((a, b) => b.created.localeCompare(a.created));
  return {
    folderUrl: folder.getUrl(),
    files: out.slice(0, 50)
  };
}
