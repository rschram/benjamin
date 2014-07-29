<?php
/**
 * DokuWiki Benajamin Template: a study of Starter Template by Anika Henke <anika@selfthinker.org>
 *
 * @link     http://rschram.org/code/benjamin.zip
 * @author   Ryan Schram <ryan@rschram.org>
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

if (!defined('DOKU_INC')) die(); /* must be run from within DokuWiki */
@require_once(dirname(__FILE__).'/tpl_functions.php'); /* include hook for template functions */
header('X-UA-Compatible: IE=edge,chrome=1');

$showTools = !tpl_getConf('hideTools') || ( tpl_getConf('hideTools') && !empty($_SERVER['REMOTE_USER']) );
$showSidebar = page_findnearest($conf['sidebar']) && ($ACT=='show');
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang'] ?>"
  lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>" class="no-js">
<head>
    <meta charset="UTF-8" />
    <title><?php tpl_pagetitle() ?> [<?php echo strip_tags($conf['title']) ?>]</title>
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
    <?php tpl_metaheaders() ?>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <?php tpl_includeFile('meta.html') ?>
</head>

<body>
    <?php /* With these conditional comments you can better address IE
             issues in CSS files, precede CSS rules by #IE7 for IE7
             and #IE8 for IE8 (div closes at the bottom) */ ?>

    <!--[if lte IE 7 ]><div id="IE7"><![endif]--><!--[if IE 8 ]><div id="IE8"><![endif]-->

    <?php /* the "dokuwiki__top" id is needed somewhere at the top,
	     because that's where the "back to top" button/link links
	     to */ ?>

    <?php /* tpl_classes() provides useful CSS classes; if you choose
	  not to use it, the 'dokuwiki' class at least should always
	  be in one of the surrounding elements (e.g. plugins and
	  templates depend on it) */ ?>

    <div id="dokuwiki__site"><div id="dokuwiki__top" class="site <?php echo tpl_classes(); ?> <?php
        echo ($showSidebar) ? 'hasSidebar' : ''; ?>">
        <?php html_msgarea() /* occasional error and info messages on top of the page */ ?>
        <?php tpl_includeFile('header.html') ?>

        <!-- ********** HEADER ********** -->
        <div id="dokuwiki__header"><div class="pad">

            <div class="headings">
                <h1><?php tpl_link(wl(),$conf['title'],'accesskey="h" title="[H]"') ?></h1>

                <?php /* How to insert logo instead (if no CSS image
                         replacement technique is used): upload your
                         logo into the data/media folder (root of the
                         media manager) and replace 'logo.png'
                         accordingly:

                        tpl_link(wl(),'<img src="'.ml('logo.png').'" alt="'.$conf['title'].'" />','id="dokuwiki__top" accesskey="h" title="[H]"')

		      */ ?>
                <?php if ($conf['tagline']): ?>
                    <p class="claim"><?php echo $conf['tagline'] ?></p>
                <?php endif ?>
            </div>



            <hr class="a11y" />
        </div></div><!-- /header -->


        <div class="wrapper">


	  <!-- ********** CONTENT ********** -->
          <div id="dokuwiki__content"><div class="pad">
              <?php tpl_flush() /* flush the output buffer */ ?>
              <?php tpl_includeFile('pageheader.html') ?>
	      
              <div class="page">
                <!-- wikipage start -->
                <?php tpl_content() /* the main content */ ?>
                <!-- wikipage stop -->
              </div>

              <?php tpl_flush() ?>
              <?php tpl_includeFile('pagefooter.html') ?>
          </div></div><!-- /content -->

          <hr class="a11y" />




          <!-- ********** TOOLS ********** -->
          <div id="dokuwiki__tools">
            <!-- SITE TOOLS -->
            <div class="tools" id="dokuwiki__sitetools">
              <h3><?php echo $lang['site_tools'] ?></h3>
              <ul>
		<li><?php tpl_searchform() ?></li>
                <?php _tpl_toolsevent('sitetools', array(
                      'recent'    => tpl_action('recent', 1, 'li', 1),
                      'media'     => tpl_action('media', 1, 'li', 1),
                      'index'     => tpl_action('index', 1, 'li', 1),
                  )); ?>
              </ul>
            </div>


            <!-- PAGE ACTIONS -->
            <?php if ($showTools): ?>
            <div class="tools" id="dokuwiki__pagetools">
              <h3><?php echo $lang['page_tools'] ?></h3>
              <ul>
                <?php _tpl_toolsevent('pagetools', array(
                      'edit'      => tpl_action('edit', 1, 'li', 1),
                      'discussion'=> _tpl_action('discussion', 1, 'li', 1),
                      'revisions' => tpl_action('revisions', 1, 'li', 1),
                      'backlink'  => tpl_action('backlink', 1, 'li', 1),
                      'subscribe' => tpl_action('subscribe', 1, 'li', 1),
                      'revert'    => tpl_action('revert', 1, 'li', 1),
                      'top'       => tpl_action('top', 1, 'li', 1),
                 )); ?>
              </ul>
            </div>
            <?php endif; ?>


            <!-- USER TOOLS -->
            <?php if ($conf['useacl'] && $showTools): ?>
            <div class="tools" id="dokuwiki__usertools">
              <h3><?php echo $lang['user_tools'] ?></h3>
              <ul>
                <?php
                   if (!empty($_SERVER['REMOTE_USER'])) {
                     echo '<li class="user">';
                     tpl_userinfo(); /* 'Logged in as ...' */
                     echo '</li>';
                   }
                 ?>

                 <?php /* the optional second parameter of
                        tpl_action() switches between a link and a
                        button, e.g. a button inside a <li> would be:
                        tpl_action('edit', 0, 'li') 
		       */ ?>

                 <?php _tpl_toolsevent('usertools', array(
                       'admin'     => tpl_action('admin', 1, 'li', 1),
                       'userpage'  => _tpl_action('userpage', 1, 'li', 1),
                       'profile'   => tpl_action('profile', 1, 'li', 1),
                       'register'  => tpl_action('register', 1, 'li', 1),
                       'login'     => tpl_action('login', 1, 'li', 1),
                  )); ?>
              </ul>
            </div>
            <?php endif ?>



          </div>




          <!-- ********** ASIDE ********** -->
          <?php if ($showSidebar): ?>
          <div id="dokuwiki__aside"><div class="pad aside include group">
              <?php tpl_includeFile('sidebarheader.html') ?>
              <?php tpl_include_page($conf['sidebar'], 1, 1) /* includes the nearest sidebar page */ ?>
              <?php tpl_includeFile('sidebarfooter.html') ?>
          </div></div><!-- /aside -->
          <?php endif; ?>






        </div><!-- /wrapper -->




        <!-- ********** FOOTER ********** -->
        <div id="dokuwiki__footer"><div class="pad">
            <div class="doc"><?php tpl_pageinfo() /* 'Last modified' etc */ ?></div>
            <?php tpl_license('button') /* content license, parameters: img=*badge|button|0, imgonly=*0|1, return=*0|1 */ ?>
        </div></div><!-- /footer -->

        <?php tpl_includeFile('footer.html') ?>
    </div></div><!-- /site -->

    <div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
    <!--[if ( lte IE 7 | IE 8 ) ]></div><![endif]-->
</body>
</html>
