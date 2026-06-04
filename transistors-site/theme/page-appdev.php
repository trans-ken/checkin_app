<?php
/**
 * 固定ページ「アプリ開発」 /appdev （静的版 appdev.html を踏襲）
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$tpl = get_template_directory_uri();
?>
<section class="lphero navy"><div class="wrap lphero-grid"><div class="lpcontent">
  <div class="eyebrow">// AI · CONTRACT DEV · FREE APPS</div>
  <h1>ちょっとしたアプリ開発。<br>AIで<span style="color:var(--azure-300)">スイッチする</span>。</h1>
  <p class="lead">「これがあると便利だな」——ちょっとした効率化のためのGAS（Google Apps Script）やWEBアプリを、AIを活用して低コストで開発します。</p>
  <div class="stats"><div><div class="v">AI</div><div class="l">低コスト開発</div></div><div><div class="v">受託</div><div class="l">開発を事業に</div></div><div><div class="v">無償</div><div class="l">ライセンス配布</div></div></div>
</div><img class="lpimg" src="<?php echo esc_url( $tpl . '/assets/illust/appdev.png' ); ?>" alt=""></div></section>
<section class="sec"><div class="wrap">
  <div class="k2" style="color:var(--navy-700)">// WHAT WE OFFER</div><h2 class="t" style="margin-bottom:40px">アプリ開発の支援メニュー</h2>
  <div class="grid2"><div class="feat"><div class="fi" style="background:rgba(5,44,73,.07);color:var(--navy-700)"><i data-lucide="sparkles"></i></div><div><h3>AIアプリ開発（受託）</h3><p>AIを活用し、短期間・低コストで業務アプリを開発・納品します。</p></div></div><div class="feat"><div class="fi" style="background:rgba(5,44,73,.07);color:var(--navy-700)"><i data-lucide="package"></i></div><div><h3>無償アプリの配布</h3><p>当社開発のアプリを、ライセンスにご同意のうえ無償でご提供します。</p></div></div><div class="feat"><div class="fi" style="background:rgba(5,44,73,.07);color:var(--navy-700)"><i data-lucide="file-lock-2"></i></div><div><h3>ライセンス提供</h3><p>利用規約に基づき、ファイルとマニュアルをダウンロード提供します。</p></div></div><div class="feat"><div class="fi" style="background:rgba(5,44,73,.07);color:var(--navy-700)"><i data-lucide="workflow"></i></div><div><h3>内製化の支援</h3><p>開発プロセスの設計や、社内での内製化のご相談にも対応します。</p></div></div></div>
</div></section>
<section style="padding:0 0 80px"><div class="wrap"><div class="lpcta" style="background:rgba(5,44,73,.07)"><h2>アプリ開発を、いっしょにスイッチしませんか。</h2><p>ご相談・お見積もりは無料です。お気軽にお問い合わせください。</p><a class="btn btn-lg" style="background:var(--navy-800);color:#fff" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">アプリ開発を相談する</a></div></div></section>
<?php
get_footer();
