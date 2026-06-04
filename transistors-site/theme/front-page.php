<?php
/**
 * フロントページ（静的版 index.html を踏襲）
 * 固定ページ「ホーム」を「設定 > 表示設定」でフロントページに指定して使用。
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$tpl = get_template_directory_uri();
?>

<section class="hero">
  <svg class="traces" viewBox="0 0 1440 600" preserveAspectRatio="xMaxYMid slice" aria-hidden="true">
    <g stroke="var(--azure-200)" stroke-width="1.5" fill="none"><path d="M1180 0 v120 h120"/><path d="M1280 200 h160"/><path d="M1080 80 v200 h180"/><path d="M1240 360 h200"/><path d="M1340 120 v160"/></g>
    <g fill="var(--azure-300)"><circle cx="1180" cy="120" r="4"/><circle cx="1280" cy="200" r="4"/><circle cx="1080" cy="280" r="4"/><circle cx="1340" cy="280" r="4"/><circle cx="1240" cy="360" r="4"/></g>
  </svg>
  <div class="wrap hero-grid" style="position:relative">
    <div class="herotext">
    <div class="eyebrow">// STEAM · SPORTS · BUSINESS</div>
    <h1>教育と<span style="color:var(--azure-500)">スポーツ</span>、<br>ビジネスを<span style="color:var(--azure-500)">スイッチする</span>。</h1>
    <p class="lead">トランジスターズは、プロフェッショナルな変革者（トランジスター）と共に、テクノロジーを活用し、教育・スポーツ・ビジネスを改革し、より良い未来を創造します。</p>
    <div class="cta"><a class="btn btn-pri btn-lg" href="<?php echo esc_url( home_url( '/#services' ) ); ?>">事業内容を見る</a><a class="btn btn-out btn-lg" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">お問い合わせ →</a></div>
    </div><img class="heroimg" src="<?php echo esc_url( $tpl . '/assets/illust/hero.png' ); ?>" alt="">
  </div>
</section>

<section class="mission"><div class="wrap mission-grid"><div>
  <div class="k">OUR MISSION</div>
  <p class="m">私たちは変革者と共に、教育やスポーツ、ビジネスを<br>改革し、より良い未来を創造していく。</p>
  <p class="s">トランジスターは電気信号を制御・増幅する半導体デバイス。「スイッチする、大きくする」という<br>意味があります。トランジスターズな人たちは変革者であり、推進者です。大事な仲間です。</p>
  </div><img class="missionimg" src="<?php echo esc_url( $tpl . '/assets/illust/mission.png' ); ?>" alt=""></div></section>

<section class="sec" id="services"><div class="wrap">
  <div class="k2">// SERVICES</div><h2 class="t">事業内容</h2><p class="sub">教育・スポーツ・ビジネス・アプリ開発、4つの領域でスイッチする。</p>
  <div class="grid3" style="grid-template-columns:repeat(4,1fr);gap:18px">
    <a class="card" href="<?php echo esc_url( home_url( '/education/' ) ); ?>"><img src="<?php echo esc_url( $tpl . '/assets/illust/education.png' ); ?>" alt="" style="width:100%;border-radius:12px;background:var(--azure-50);margin-bottom:18px;display:block"><div class="ctag" style="color:var(--azure-600)">STEAM · PBL</div><h3>教育</h3><p>ICT・STEAM教育の推進、PBLを中心としたカリキュラム設計、教員研修・授業支援。</p><span class="more">詳しく見る →</span></a>
    <a class="card" href="<?php echo esc_url( home_url( '/sports/' ) ); ?>"><img src="<?php echo esc_url( $tpl . '/assets/illust/sports.png' ); ?>" alt="" style="width:100%;border-radius:12px;background:var(--azure-50);margin-bottom:18px;display:block"><div class="ctag" style="color:var(--navy-600)">CONSULTING</div><h3>スポーツ</h3><p>スポーツビジネスのコンサルティング。競技団体やクラブの運営・育成・事業化を支援します。</p><span class="more" style="color:var(--navy-700)">詳しく見る →</span></a>
    <a class="card" href="<?php echo esc_url( home_url( '/business/' ) ); ?>"><img src="<?php echo esc_url( $tpl . '/assets/illust/business.png' ); ?>" alt="" style="width:100%;border-radius:12px;background:var(--azure-50);margin-bottom:18px;display:block"><div class="ctag" style="color:var(--navy-600)">DX · 研修</div><h3>ビジネス</h3><p>コンサルティングと研修で、DX推進・プロジェクトマネジメント・人材育成を支援します。</p><span class="more" style="color:var(--navy-700)">詳しく見る →</span></a>
    <a class="card" href="<?php echo esc_url( home_url( '/appdev/' ) ); ?>"><img src="<?php echo esc_url( $tpl . '/assets/illust/appdev.png' ); ?>" alt="" style="width:100%;border-radius:12px;background:var(--azure-50);margin-bottom:18px;display:block"><div class="ctag" style="color:var(--navy-600)">AI · 受託</div><h3>アプリ開発</h3><p>AIを活用した低コストなアプリ開発（受託）。開発アプリはライセンス制で無償配布。</p><span class="more" style="color:var(--navy-700)">詳しく見る →</span></a>
  </div>
</div></section>

<section class="sec blogwrap"><div class="wrap">
  <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:40px"><div><div class="k2">// BLOG</div><h2 class="t" style="margin:0">transistor's Blog</h2></div><a class="more" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">記事一覧 →</a></div>
  <div class="grid3">
    <?php
    $front_blog = new WP_Query( array( 'posts_per_page' => 3, 'ignore_sticky_posts' => true ) );
    if ( $front_blog->have_posts() ) :
      while ( $front_blog->have_posts() ) : $front_blog->the_post();
        $cat = transistors_primary_category();
        ?>
        <a class="card" href="<?php the_permalink(); ?>" style="padding:0;overflow:hidden"><div class="thumb" style="background:<?php echo esc_attr( transistors_thumb_gradient( $cat ) ); ?>"><?php if ( $cat ) : ?><span class="cat"><?php echo esc_html( $cat ); ?></span><?php endif; ?></div><div class="pad"><div class="d"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></div><h3><?php the_title(); ?></h3></div></a>
        <?php
      endwhile;
      wp_reset_postdata();
    else :
      // 投稿が無い場合は静的版のサンプルカードを表示
      ?>
      <a class="card" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" style="padding:0;overflow:hidden"><div class="thumb" style="background:linear-gradient(135deg,var(--azure-100),var(--azure-300))"><span class="cat">教育</span></div><div class="pad"><div class="d">2024.03.12</div><h3>PBLで「問い」を立てる授業づくり</h3></div></a>
      <a class="card" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" style="padding:0;overflow:hidden"><div class="thumb" style="background:linear-gradient(135deg,var(--azure-50),var(--azure-200))"><span class="cat">ビジネス</span></div><div class="pad"><div class="d">2024.02.28</div><h3>DX推進、最初の一歩は「現場の言葉」から</h3></div></a>
      <a class="card" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" style="padding:0;overflow:hidden"><div class="thumb" style="background:linear-gradient(135deg,var(--azure-200),var(--azure-400))"><span class="cat">スポーツ</span></div><div class="pad"><div class="d">2024.02.05</div><h3>データで練習を変える。スポーツ現場のAI活用</h3></div></a>
      <?php
    endif;
    ?>
  </div>
</div></section>

<section class="ctaband"><div class="wrap"><div class="inner"><h2>いっしょに、スイッチしませんか。</h2><p>お気軽にお問い合わせください。</p><a class="btn btn-pri btn-lg" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">お問い合わせ</a></div></div></section>

<?php
get_footer();
