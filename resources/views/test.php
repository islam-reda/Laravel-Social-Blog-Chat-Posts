<?php
$routeName = Mage::app()->getRequest()->getRouteName();
$identifier = Mage::getSingleton('cms/page')->getIdentifier();
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    design
 * @package     base_default
 * @copyright   Copyright (c) 2014 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
/**
 * @var Mage_Page_Block_Html_Header $this
 */
?>
<div id="em-mheader" class="visible-xs container">
    <div id="em-mheader-top" class="row">
        <div id="em-mheader-logo" class="col-xs-24">
            <div class="em-logo text-center"><a href="<?php echo $this->getUrl('') ?>" title="<?php echo $this->getLogoAlt() ?>" class="logo"><strong><?php echo $this->getLogoAlt() ?></strong><img src="<?php echo $this->getLogoSrcSmall() ?>" alt="<?php echo $this->getLogoAlt() ?>" /></a></div>
        </div>
        <div class="col-xs-24">
            <div class="em-top-search"><?php echo $this->getChildHtml('topsearch_mobile') ;?></div>
            <div class="em-top-cart"><?php echo $this->getChildHtml('em_topcart_mobile'); ?></div>
            <div id="em-mheader-wrapper-menu">
                <span class="visible-xs fa fa-bars" id="em-mheader-menu-icon"></span>
                <div id="em-mheader-menu-content" style="display: none;">
                    <div class="em-wrapper-top">
                        <div class="em-language-currency row">
                            <div class="col-sm-24">
                                <?php echo $this->getChildHtml('store_language_mobile') ?>
                                <?php echo $this->getChildHtml('currency_style_mobile') ?>
                            </div>
                        </div>
                        <div class="em-top-links row">
                            <div class="">
                                <ul class="top-header-link links">
                                    <?php if (Mage::getSingleton('customer/session')->isLoggedIn()!=0): ?>
                                        <li class="em-clear-padding col-sm-8">
                                            <a title="<?php echo $this->__('My Account')?>" class="account-link fa fa-user" href="<?php echo $this->getBaseUrl()?>customer/account/" ><span><?php echo $this->__('My Account') ?></span></a>
                                        </li>
                                        <li class="em-clear-padding col-sm-8">
                                            <a title="<?php echo $this->__('Log out')?>" class='account-link fa fa-sign-out' href=" <?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK).'customer/account/logout' ?>"><span><?php echo $this->__('Log out')?></span></a>
                                        </li>
                                    <?php else:?>
                                        <li class="em-clear-padding col-sm-8">
                                            <a title="<?php echo $this->__('Log In')?>" class="login-link fa fa-user" href="<?php echo $this->getBaseUrl()?>customer/account/login/" ><span><?php echo $this->__('Log In') ?></span></a>
                                        </li>
                                        <li class="em-clear-padding col-sm-8">
                                            <a title="<?php echo $this->__('Sign up')?>" class='signup-link fa fa-sign-out' href=" <?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK).'customer/account/create' ?>"><span><?php echo $this->__('Sign up')?></span></a>
                                        </li>
                                    <?php endif;?>
                                    <li class="em-clear-padding col-sm-8">
                                        <a href="<?php echo $this->getBaseUrl()?>checkout/cart" class="checkout-link fa fa-shopping-cart"><span><?php echo $this->__('Cart') ?></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row mobile-main-menu toggle-menu">
                        <div class="col-sm-24">
                            <div class="em-top-menu">
                                <?php echo $this->getChildHtml('topMenuMobile') ?>
                            </div>
                        </div>
                    </div>
                    <div class="row mobile-block">
                        <div class="col-sm-24"><?php echo $this->getChildHtml('em_area_header_mobile') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    //<![CDATA[
    (function($) {
        function getWindowWidth() {
            var w = window;
            var d = document;
            var e = d.documentElement;
            var g = d.getElementsByTagName('body')[0];
            var x = w.innerWidth||e.clientWidth||g.clientWidth;
            return x;
        };
        function fixNavigationMobileView(){
            var $_winW = getWindowWidth();
            var $_mmenu = $('#em-mheader-menu-content');
            var elem = $('#em-mheader-menu-content');
            var $_parent = $('#em-mheader-wrapper-menu');
            var $_iconNav = $('#em-mheader-menu-icon');
            if(!isPhone || $_winW>767){
                $_mmenu.removeClass();
                $_iconNav.removeClass('active');
                elem.removeClass('show');
                $_parent.removeClass('active');
            }
        };
        function fixNavOverFlow(){
            var $_iconNav = $('#em-mheader-menu-icon');
            var elem = $('#em-mheader-menu-content');
            var $_parent = $('#em-mheader-wrapper-menu');
            $_iconNav.click(function(e){
                e.preventDefault();
                var self = $(this);
                var isSkipContentOpen = elem.hasClass('show') ? 1 : 0;
                self.removeClass('active');
                elem.removeClass('show');
                $_parent.removeClass('active');
                if (isSkipContentOpen) {
                    self.removeClass('active');
                    $_parent.removeClass('active');
                } else {
                    self.addClass('active');
                    elem.addClass('show');
                    $_parent.addClass('active');
                }
            });
            if(isPhone){
                $_parent.on("swiperight",function(){
                    var self = $(this);
                    if(self.hasClass('active')){
                        elem.removeClass('show');
                        $_iconNav.removeClass('active');
                        self.removeClass('active');
                    }
                });
            }
        };
        $(document).ready(function(){
            if (EM.SETTING.DISABLE_RESPONSIVE != 0) {
                fixNavigationMobileView();
                fixNavOverFlow();
            }
        });
        $(window).resize($.throttle(300,function(){
            if (EM.SETTING.DISABLE_RESPONSIVE != 0) {
                fixNavigationMobileView();
            }
        }));
    })(jQuery);
    //]]>
</script>
<div class="hidden-xs em-header-style02">

    <?php if(Mage::helper('themeframework/settings')->getGeneral_StickyElement()): ?>
        <div id="em-fixed-top"></div>
    <?php endif;?>
    <div class="em-header-middle <?php if(Mage::helper('themeframework/settings')->getGeneral_StickyElement()): ?>em-fixed-top<?php endif;?>">
        <div class="<?php echo (Mage::getBlockSingleton('page/html_header')->getIsHomePage()) ? 'djvcontainer' : 'container'; ?> em-menu-fix-pos">
            <div class="row">
                <div class="col-sm-24">
                    <div class="em-logo f-left"><a href="<?php echo $this->getUrl('') ?>" title="<?php echo $this->getLogoAlt() ?>" class="logo"><strong><?php echo $this->getLogoAlt() ?></strong><img class="retina-img" src="<?php echo $this->getLogoSrc() ?>" alt="<?php echo $this->getLogoAlt() ?>" /></a></div>
                    <?php if(Mage::helper('themeframework/settings')->getGeneral_StickyElement()): ?>
                        <div class="em-logo-sticky f-left"><a href="<?php echo $this->getUrl('') ?>" title="<?php echo $this->getLogoAlt() ?>" class="logo"><img src="<?php echo $this->getLogoSrcSmall() ?>" alt="<?php echo $this->getLogoAlt() ?>" /></a></div>
                        <div class="em-top-cart-sticky em-top-cart f-right">
                            <?php echo $this->getChildHtml('cart_sidebar'); ?>
                        </div>
                        <div class="em-search em-search-sticky f-right">
                            <div class="em-top-search"><?php echo $this->getChildHtml('topsearch_fixed') ;?></div>
                        </div>
                    <?php endif;?>
                    <div class="em-menu-hoz">
                        <div id="em-main-megamenu">
                            <div class="f-left">
                                <?php echo $this->getChildHtml('topMenu');?>
                            </div>
                            <div class="f-right pers-info-column">
                                <div class="col-sm-24">
                                    <div class="f-right">
                                        <div class="em-language-currency">
                                            <?php echo $this->getChildHtml('store_language_style01') ?>
                                            <?php echo $this->getChildHtml('em_currency_style01') ?>
                                        </div>
                                    </div>
                                    <div class="f-right">
                                        <div class="em-top-cart f-right">
                                            <?php echo $this->getChildHtml('cart_sidebar'); ?>
                                        </div>
                                        <div class="em-search f-right">
                                            <div class="em-top-search"><?php echo $this->getChildHtml('topsearch_hover') ;?></div>
                                        </div>
                                        <div class="em-top-links f-right">
                                            <div class="f-right"><?php echo $this->getChildHtml('topLinks') ?></div>
                                            <!-- <div class="f-right"><?php// echo $this->getChildHtml('topLinksWishlist') ?></div> -->
                                            <ul class="list-inline f-right">
                                                <?php if (Mage::getSingleton('customer/session')->isLoggedIn()==0): ?>
                                                    <li><a class="em-register-link" href="<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK).'customer/account/create/'; ?>" title="<?php echo $this->__('Register') ?>"><?php echo $this->__('Register') ?></a></li>
                                                <?php else: ?>
                                                    <li><a href="<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK).'customer/account/'; ?>" class="em-account-link" title="<?php echo $this->__('My Account') ?>"><?php echo $this->__('My Account') ?></a></li>
                                                    <li><a href="<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK).'customer/account/logout'; ?>" class="em-logout-link" title="<?php echo $this->__('Log Out') ?>"><?php echo $this->__('Log Out') ?></a></li>
                                                <?php endif;?>
                                            </ul>
                                            <div id="em-login-link" class="account-link f-right <?php if (Mage::getSingleton('customer/session')->isLoggedIn()==0): ?>em-non-login<?php else:?>em-logged<?php endif;?>">
                                                <?php if (Mage::getSingleton('customer/session')->isLoggedIn()==0): ?>
                                                    <a href="<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK).'customer/account/login/'; ?>" class="link-account" id="link-login" title="<?php echo $this->__('Login') ?>"><?php echo $this->__('Login') ?></a>
                                                    <?php if(Mage::helper('themeframework/settings')->getGeneral_DisableHoverLogin()!=0 && !Mage::helper('themeframework/settings')->checkPhone()): ?>
                                                        <?php $login = new Mage_Customer_Block_Form_Login(); ?>
                                                        <div class="em-account" id="em-account-login-form" style="display: none;">
                                                            <form action="<?php echo $login->getPostActionUrl() ?>" method="post" id="top-login-form">
                                                                <?php echo $this->getBlockHtml('formkey'); ?>
                                                                <div class="block-content">
                                                                    <p class="login-title h6 primary"><?php echo $this->__('Login') ?></p>
                                                                    <p class="login-desc"><?php echo $this->__('If you have an account with us, please log in.') ?></p>
                                                                    <ul class="form-list">
                                                                        <li><label for="mini-login"><?php echo $this->__('Email Address') ?><em><?php echo $this->__('*') ?></em></label>
                                                                            <input type="text" name="login[username]" id="mini-login" class="input-text required-entry validate-email" />
                                                                        </li>
                                                                        <li><label for="mini-password"><?php echo $this->__('Password') ?><em><?php echo $this->__('*') ?></em></label>
                                                                            <input type="password" name="login[password]" id="mini-password" class="input-text required-entry validate-password" />
                                                                        </li>
                                                                        <li><span class="required"><?php echo $this->__('* Required Fields') ?></span></li>
                                                                    </ul>
                                                                    <div class="action-forgot">
                                                                        <div class="login_forgotpassword">
                                                                            <p><a href="<?php echo $login->getForgotPasswordUrl() ?>"><?php echo $this->__('Forgot Your Password?') ?></a></p>
                                                                            <p><span><?php echo $this->__("Don't have an account?") ?></span><a class="create-account-link-wishlist" href="<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK).'customer/account/create/'; ?>" title="<?php echo $this->__('Sign Up') ?>"><?php echo $this->__("Sign Up") ?></a></p>
                                                                        </div>
                                                                        <div class="actions">
                                                                            <button type="submit" class="button"><span><span><?php echo $this->__('Login') ?></span></span></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <script type="text/javascript">
                                                                //<![CDATA[
                                                                var dataTopLoginForm = new VarienForm('top-login-form', true);
                                                                //]]>
                                                            </script>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif;?>
                                                <?php if(Mage::helper('themeframework/settings')->getGeneral_DisableHoverLogin()!=0 && !Mage::helper('themeframework/settings')->checkPhone()): ?>
                                                    <script type="text/javascript">
                                                        //<![CDATA[
                                                        (function($) {
                                                            function effectLoginForm() {
                                                                var sLogin = $('#em-account-login-form');
                                                                var sLink = $('#link-login');
                                                                var sDivLink = $('#em-login-link');
                                                                if (sLogin.length > 0) {
                                                                    //hover login form
                                                                    <?php if(Mage::helper('themeframework/settings')->getGeneral_DisableHoverLogin()==1): ?>
                                                                    if (isMobile) {

                                                                        sLink.attr('href', 'javascript:void(0);');
                                                                        sLink.click(function(e) {
                                                                            sLogin.slideToggle();
                                                                        });
                                                                    } else {
                                                                        var tmlink;

                                                                        function showlink(el) {
                                                                            clearTimeout(tmlink);
                                                                            tmlink = setTimeout(function() {
                                                                                el.slideDown();
                                                                            }, 200);
                                                                        }
                                                                        function hidelink(el) {
                                                                            clearTimeout(tmlink);
                                                                            tmlink = setTimeout(function() {
                                                                                el.slideUp();
                                                                            }, 200);
                                                                        }
                                                                        sDivLink.mouseover(function(){
                                                                            showlink(sLogin);
                                                                        });
                                                                        sDivLink.mouseout(function(){
                                                                            hidelink(sLogin);
                                                                        });
                                                                    }
                                                                    // Popup Login Form
                                                                    <?php elseif(Mage::helper('themeframework/settings')->getGeneral_DisableHoverLogin()==2): ?>
                                                                    sLink.attr('href', 'javascript:void(0);');
                                                                    $("#link-login").click(function(){
                                                                        $.fancybox.open('#em-account-login-form',{
                                                                            minWidth: 300,
                                                                            minHeight: 380,
                                                                            openEffect  : 'elastic',
                                                                            closeEffect : 'elastic'
                                                                        });
                                                                    });
                                                                    <?php endif; ?>
                                                                }
                                                            }
                                                            $(document).ready(function(){
                                                                effectLoginForm();
                                                            });
                                                        })(jQuery);
                                                        //]]>
                                                    </script>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

$categories = Mage::getModel('catalog/category')
    ->getCollection()
    ->addAttributeToSelect('*')
    ->addAttributeToFilter('is_active',0);
$dis_Active_Categories_url = array();
foreach ($categories as $key => $category) {
    $dis_Active_Categories_url[] = str_replace("https","http",$category->getUrl());
}
$urlJson = Mage::helper('core')->jsonEncode($dis_Active_Categories_url);

?>

<script>
    jQuery(document).ready(function($){

        $('.em-container-js-search').hide(500);
        $(".em-search-style-hover").unbind();
        $(".em-search-style01").unbind();

        $(".em-top-search .em-search-icon").click(function(){
            $(".em-search-style-hover").unbind();
            $(".em-search-style01").unbind();
            $('.em-container-js-search').toggle(500);

        });


        var disableUrls = <?php echo $urlJson; ?>;

        var disableUrlsArr = eval(disableUrls);

        $('.menu-item-link .menu-container .em-catalog-navigation li .em-menu-link').each(function(e,ancor){
            $.each(disableUrlsArr,function(key,url){

                if($(ancor).attr('href') == url){

                    $(ancor).parent().hide();

                }
            });
        });


    });
</script>