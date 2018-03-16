<?php
/*
*  @Module Name : Raychat
*  @Version : 0.1
*  @Author Alireza Ahmadi SA <alireza@p30web.org>
*  @Author Web SIte : p30web.org
*  @Implement in: Raychat
*  Description :  Online chat platform and customer relationship
*
*/

if (!defined('_PS_VERSION_'))
    exit;

class raychat extends Module
{
    public function __construct()
    {
        $this->name = 'raychat';
        //$this->tab = 'front_office_features';
        $this->tab = 'advertising_marketing';
        $this->version = '0.1';
        $this->author = 'Raychat';
        $this->need_instance = 1;
        $this->ps_versions_compliancy = array('min' => '1.3', 'max' => _PS_VERSION_);
        $this->dependencies = array('blockcart');
        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('raychat');
        $this->description = $this->l('Online chat platform and customer relationship');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('RayChat_Code'))
            $this->warning = $this->l('برای استفاده از رایچت باید توکن کانال را وارد کنید.');
    }

//    public function install()
//    {
//        if (Shop::isFeatureActive())
//            Shop::setContext(Shop::CONTEXT_ALL);
//
//        return parent::install() && $this->registerHook('header');
//    }

    public function install()
    {

        if (!parent::install() || !$this->registerHook('footer') )
         {
            return false;
        }

        return true;
    }

    public function uninstall()
    {

        if (parent::uninstall() && $this->registerHook('footer'))
        {
            Configuration::deleteByName('RayChat_Code');
            return true;
        }

        return false;
    }

    public function getContent()
    {
        $output = null;

        $RaychatGobal_Code = Configuration::get('RayChat_Code');
        $RaychatAjax_Code = Tools::getValue('RayChat_Code');
        $Token = "";

        if(!empty($RaychatAjax_Code) && $RaychatAjax_Code != false){
            $Token = $RaychatAjax_Code;
        }elseif (empty($RaychatAjax_Code) || $RaychatAjax_Code == false){
            $Token = $RaychatGobal_Code;
        }


        $TokenStayus = preg_match("/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/", $Token);

        $Text = "<div class='panel'>";
        $Text .= '<h3><i class="icon-list-ul"></i> راهنمای نصب و راه اندازی هوشمند ';
        $Text .= '<span class="panel-heading-action">';
        $Text .= '<a target="_blank" id="desc-product-new" class="list-toolbar-btn" href="https://raychat.io/contact">';
        $Text .= '<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="راهنمایی و دریافت مشاوره" data-html="true">';
        $Text .= '<i class="process-icon-help"></i></span></a></span></h3>';
        //$Text .= "Token : $Token";

            if(!empty($Token)){
                if($TokenStayus == "1"){
                    $Text .= "<div class='row'><strong><span class='title'>کد رایجت وارد شده صحیح می باشد و رایچت شما با موفقیت فعال شده است. </span></strong>";
                    $Text .= "</div>";
                    $Text .= '<br><p>';
                    $Text .= '<a class="btn btn-default" href="https://app.raychat.io">ورود به اپلیکیشن تحت وب</a>  ';
                    $Text .= '<a class="btn btn-primary" href="https://raychat.io/login" target="_blank">ورود به پنل مدیریت</a>   ';
                    $Text .= '<a class="btn btn-default" href="https://raychat.io/contact" target="_blank">ارتباط با پشتیبانی</a>';
                    $Text .= '</p>';
                }elseif ($TokenStayus == "0"){
                    $Text .= "<div class='row'><strong><span class='title' style='color: red;'>متاسفانه کد توکن وارد شده اشتباه است و رایچت شما فعال نشده ! </span></strong>";
                    $Text .= "</div>";
                    $Text .= '<br><p>';
                    $Text .= '<a class="btn btn-default" href="https://app.raychat.io" target="_blank">ورود به اپلیکیشن تحت وب</a>  ';
                    $Text .= '<a class="btn btn-primary" href="https://raychat.io/login" target="_blank">ورود به پنل مدیریت</a>  ';
                    $Text .= '<a class="btn btn-default" href="https://raychat.io/contact" target="_blank">ارتباط با پشتیبانی</a>';
                    $Text .= '</p>';
                }
            }elseif (empty($Token)){
                $Text .= "<div class='errorbox'><strong><span class='title' style='color: red'>رایچت فعال نمی باشد ، توکن را وارد کنید ! </span></strong>";
                $Text .= "<div class='gray_form'>";
                $Text .= "<br><p> تبریک می گوییم، شما برای نصب ابزارک رایچت در سایتتان نصف راه را پیموده اید :)</p>";
                $Text .= "<p>اکنون از پنل : " . "<p><a class='btn btn-primary' href='http://raychat.io/admin' target='_blank'> مدیریت رایچت </a></p>" . "<span style='color: #292dff'>از قسمت نصب و تنظیمات  : </span>" . "<span style='color: red'>توکن کانال مورد نظر را در کادر زیر وارد کنید.</span>" . "</p>";
                $Text .= "<p>چنانچه تا کنون در رایچت عضو نشده اید میتوانید از طریق لینک زیر در رایچت عضو شوید و به صورت نامحدود " . " با کاربران وبسایتتون مکالمه کنید و فروش خود را چند برابر کنید " . "</p>";
                $Text .= "<p><a class='btn btn-primary' href='http://raychat.io/signup' target='_blank'>عضویت رایگان</a> <a class='btn btn-default' href='https://raychat.io/contact' target='_blank'>ارتباط با پشتیبانی</a> </p><p style='font-size: 12px'>رایچت، ابزار گفتگوی آنلاین |<a href='http://raychat.io/' target='_blank'>دمو</a>";
                $Text .= "</div>";
            }
        $Text .= "</div>";

        if (Tools::isSubmit('submit'.$this->name))
        {
            $my_module_name = strval(Tools::getValue('RayChat_Code'));
            if (!$my_module_name || empty($my_module_name) || !Validate::isGenericName($my_module_name))
                $output .= $this->displayError($this->l('تغییرات ناموفق بود'));
            else
            {
                Configuration::updateValue('RayChat_Code', $my_module_name);
                $output .= $this->displayConfirmation($this->l('تنظیمات ذخیره شد'));
            }
        }

        $FormDisplay = $this->displayForm();

        return $this->display(__FILE__, 'infos.tpl').$output.$FormDisplay.$Text;

        //return $this->display(__FILE__, 'views/templates/admin/configuration.tpl') . $output;
    }

    public function displayForm()
    {
        // Get default language
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

        // Init Fields form array
        $fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('پیکر بندی افزونه گفنگوی آنلاین رایچت'),
                'icon' => 'icon-cogs'
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('توکن کانال : '),
                    'name' => 'RayChat_Code',
                    'size' => 20,
                    'desc' => $this->l('توکن کانال رایچت را وارد کنید.'),
                    'required' => true
                )
            ),
            'submit' => array(
                'title' => $this->l('ذخیره'),
                'class' => 'btn btn-default pull-right'
            )
        );

        $helper = new HelperForm();

        // Module, token and currentIndex
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

        // Language
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;

        // Title and toolbar
        $helper->title = $this->displayName;
        $helper->show_toolbar = true;        // false -> remove toolbar
        $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
        $helper->submit_action = 'submit'.$this->name;
        $helper->toolbar_btn = array(
            'save' =>
                array(
                    'desc' => $this->l('Save'),
                    'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
                        '&token='.Tools::getAdminTokenLite('AdminModules'),
                ),
            'back' => array(
                'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            )
        );

        // Load current value
        $helper->fields_value['RayChat_Code'] = Configuration::get('RayChat_Code');

        return $helper->generateForm($fields_form);
    }

    public function hookFooter()
    {
        $RayChatId = Configuration::get('RayChat_Code');
        $html = '<!--BEGIN RAYCHAT.IO CODE-->';
        $html .= '{literal}<script type="text/javascript">';
        $html .= '!function(){function t(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,localStorage.getItem("rayToken")?t.src="https://app.raychat.io/scripts/js/"+o+"?rid="+localStorage.getItem("rayToken")+"&href="+window.location.href:t.src="https://app.raychat.io/scripts/js/"+o;var e=document.getElementsByTagName("script")[0];e.parentNode.insertBefore(t,e)}var e=document,a=window,o="'. $RayChatId .'";"complete"==e.readyState?t():a.attachEvent?a.attachEvent("onload",t):a.addEventListener("load",t,!1)}();';
        $html .= "</script><!--END RAYCHAT CODE-->{/literal}";

        return $html;
    }

}


?>