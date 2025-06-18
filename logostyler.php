<?php
namespace Grav\Plugin;
use Grav\Common\Plugin;

class LogoStylerPlugin extends Plugin
{
    public static function getSubscribedEvents(): array
    {
        return [
            'onTwigSiteVariables' => ['onTwigSiteVariables', 0],
        ];
    }

    public function onTwigSiteVariables()
    {
        $headerheight = $this->config->get('plugins.logostyler.header_height', 5);
        if ($this->isAdmin()) return;
        $height = $this->config->get('plugins.logostyler.logo_height', 80);
        $maxwidth = $this->config->get('plugins.logostyler.logo_maxwidth', 350);
        $paddingtop = $this->config->get('plugins.logostyler.logo_paddingtop', 0);
        $mobileheight = $this->config->get('plugins.logostyler.logo_mobile_height', 50);

        $css = "
#header {
    height: {$headerheight}rem !important;
}

.logo img, .header-logo img {
    height: {$height}px !important;
    max-height: {$height}px !important;
    max-width: {$maxwidth}px !important;
    width: auto !important;
    padding-top: {$paddingtop}px !important;
    display: inline-block;
    vertical-align: middle;
}
@media (max-width: 600px) {
    .logo img, .header-logo img {
        height: {$mobileheight}px !important;
        max-height: {$mobileheight}px !important;
    }
}
";
        $this->grav['assets']->addInlineCss($css);

        // Favicon-Support
        $favicon_cfg = $this->config->get('plugins.logostyler.favicon');
        if (!empty($favicon_cfg) && is_array($favicon_cfg) && isset($favicon_cfg[0]['name'])) {
            $favicon_url = $this->grav['base_url_absolute'] . '/user/data/logostyler/' . $favicon_cfg[0]['name'];
            // Erzwinge Favicon am Ende des Heads (überschreibt vorhandene)
            $this->grav['assets']->add('favicon', $favicon_url, 101);
        }
    }
}
