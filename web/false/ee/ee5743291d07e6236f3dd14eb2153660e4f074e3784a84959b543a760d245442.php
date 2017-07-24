<?php

/* base.html.twig */
class __TwigTemplate_25be9faec3214b27d0cddeebf481137e3ce77580f65f97ab7c6d387e2a1968d1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"es\">
\t<head>
\t\t<meta charset=\"utf-8\">
\t\t<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
\t\t<meta name=\"description\" content=\"\">
\t\t<meta name=\"keywords\" content=\"\">
\t\t<meta name=\"author\" content=\"\">
\t\t<title>Plantilla admin</title>
\t\t<link rel=\"shortcut icon\" href=\"\">

\t\t<!-- Materialize -->
\t\t<link href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpFoundationExtension')->generateAbsoluteUrl($this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("assets/css/materialize/materialize.min.css")), "html", null, true);
        echo " \" rel=\"stylesheet\">
\t\t
\t\t<!-- estilos del sitio -->
\t\t<link href=\"";
        // line 17
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpFoundationExtension')->generateAbsoluteUrl($this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("assets/css/admin.css")), "html", null, true);
        echo "\" rel=\"stylesheet\">
\t\t
\t\t<!-- configuracion de media querys -->
\t\t<link href=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpFoundationExtension')->generateAbsoluteUrl($this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("assets/css/querys.css")), "html", null, true);
        echo "\" rel=\"stylesheet\">
\t\t
\t\t<!-- lightgallery -->
\t\t<link href=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpFoundationExtension')->generateAbsoluteUrl($this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("assets/css/lightgallery/lightgallery.min.css")), "html", null, true);
        echo "\" rel=\"stylesheet\">
\t\t
\t\t<!-- Fuentes del sitio -->
\t\t<link href=\"http://fonts.googleapis.com/icon?family=Material+Icons\" rel=\"stylesheet\">

\t\t";
        // line 28
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 29
        echo "\t\t
\t\t<!--[if lt IE 9]>
\t\t  <script src=\"https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js\"></script>
\t\t  <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
\t\t<![endif]-->
\t</head>
\t<body>

\t\t<header>
\t\t\t<nav class=\"top-nav\">
        \t\t<div class=\"container\">
\t\t\t\t\t<div class=\"nav-wrapper\">
\t\t\t\t\t\t<div class=\"right-align\">
\t\t\t\t\t\t\t<a class='dropdown-button' href='#' data-activates='dropdown-usuario'>Usuario<i class=\"material-icons right\">arrow_drop_down</i></a>
\t\t\t\t\t\t\t<ul id='dropdown-usuario' class='dropdown-content'>
\t\t\t\t\t\t\t    <li><a href=\"#!\">Opcion 1</a></li>
\t\t\t\t\t\t\t    <li><a href=\"#!\">Opcion 2</a></li>
\t\t\t\t\t\t\t    <li class=\"divider\"></li>
\t\t\t\t\t\t\t    <li><a class=\"center\" href=\"#!\"><i class=\"large material-icons\">power_settings_new</i>Salir</a></li>
\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t
\t\t\t\t\t</div>
        \t\t</div>
      \t\t</nav>
      \t\t<div class=\"container\">
      \t\t\t<a href=\"#\" data-activates=\"slide-out\" class=\"button-collapse top-nav full hide-on-large-only\"><i class=\"material-icons\">menu</i></a>
      \t\t</div>

      \t\t<ul id=\"slide-out\" class=\"side-nav fixed\">
      \t\t\t<div class=\"logo center\">      \t\t\t\t
            \t\t<object id=\"front-page-logo\" type=\"image/svg+xml\" data=\"";
        // line 60
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpFoundationExtension')->generateAbsoluteUrl($this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("assets/images/logo-simple.svg")), "html", null, true);
        echo "\"></object>
            \t</div>
    \t\t  <li><a href=\"#!\">First Sidebar Link</a></li>
    \t\t  <li><a href=\"#!\">Second Sidebar Link</a></li>
    \t\t  <li class=\"no-padding\">
    \t\t    <ul class=\"collapsible collapsible-accordion\">
    \t\t      <li>
    \t\t        <a class=\"collapsible-header\">Dropdown<i class=\"material-icons\">arrow_drop_down</i></a>
    \t\t        <div class=\"collapsible-body\">
    \t\t          <ul>
    \t\t            <li><a href=\"#!\">First</a></li>
    \t\t            <li><a href=\"#!\">Second</a></li>
    \t\t            <li><a href=\"#!\">Third</a></li>
    \t\t            <li><a href=\"#!\">Fourth</a></li>
    \t\t            <li><a href=\"#!\">First</a></li>
    \t\t            <li><a href=\"#!\">Second</a></li>
    \t\t            <li><a href=\"#!\">Third</a></li>
    \t\t            <li><a href=\"#!\">Fourth</a></li>
    \t\t            <li><a href=\"#!\">First</a></li>
    \t\t            <li><a href=\"#!\">Second</a></li>
    \t\t            <li><a href=\"#!\">Third</a></li>
    \t\t            <li><a href=\"#!\">Fourth</a></li>
    \t\t          </ul>
    \t\t        </div>
    \t\t      </li>
    \t\t      <li>
    \t\t        <a class=\"collapsible-header\">Dropdown<i class=\"material-icons\">arrow_drop_down</i></a>
    \t\t        <div class=\"collapsible-body\">
    \t\t          <ul>
    \t\t            <li><a href=\"#!\">First</a></li>
    \t\t            <li><a href=\"#!\">Second</a></li>
    \t\t            <li><a href=\"#!\">Third</a></li>
    \t\t            <li><a href=\"#!\">Fourth</a></li>
    \t\t          </ul>
    \t\t        </div>
    \t\t      </li>
    \t\t    </ul>
    \t\t  </li>
    \t\t  <li><a href=\"#!\">First Sidebar Link</a></li>
    \t\t  <li><a href=\"#!\">Second Sidebar Link</a></li>
    \t\t</ul>
    \t\t
\t\t\t
\t\t</header>

\t\t<main>
\t\t\t";
        // line 106
        $this->displayBlock('body', $context, $blocks);
        // line 107
        echo "\t\t</main>

\t\t<footer class=\"page-footer\">
\t\t\t<div class=\"footer-copyright\">
\t\t\t\t<div class=\"container\">
\t\t\t\t\t© 2017 Tuciudad.cl, All rights reserved.
\t\t\t\t\t<a class=\"grey-text text-lighten-4 right\" target=\"_blank\" href=\"http://tuciudad.cl\"></a>
\t\t\t\t</div>
\t\t\t</div>
\t\t</footer>
\t\t

\t\t

\t\t
\t\t<div id=\"contenido\">
\t\t</div>
\t\t
\t\t<!-- footer fin -->
\t\t<div id=\"back-top\" class=\"\"></div>

\t\t<!-- jQuery -->
\t\t<script src=\"";
        // line 129
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpFoundationExtension')->generateAbsoluteUrl($this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("assets/js/jquery-3.1.1.min.js")), "html", null, true);
        echo "\"></script>

\t\t<script src=\"";
        // line 131
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("bundles/fosjsrouting/js/router.js"), "html", null, true);
        echo "\"></script>
\t\t<script src=\"";
        // line 132
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("fos_js_routing_js", array("callback" => "fos.Router.setData"));
        echo "\"></script>
\t\t
\t\t<!-- Framework -->
\t\t<script src=\"";
        // line 135
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpFoundationExtension')->generateAbsoluteUrl($this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("assets/js/materialize/materialize.min.js")), "html", null, true);
        echo "\"></script>
\t\t
\t\t<!-- JS Lightgallery -->
\t\t<script src=\"";
        // line 138
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpFoundationExtension')->generateAbsoluteUrl($this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("assets/js/lightgallery/lightgallery.min.js")), "html", null, true);
        echo "\"></script>
\t\t<script src=\"";
        // line 139
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpFoundationExtension')->generateAbsoluteUrl($this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("assets/js/lightgallery/plugins/lg-thumbnail.min.js")), "html", null, true);
        echo "\"></script>
\t\t
\t\t<!-- gmaps -->
\t\t<script src=\"http://maps.google.com/maps/api/js?key=AIzaSyCc6uZiwgDirdfZgc4W41fR5MDs3H02wpk\"></script>
\t\t<script src=\"https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.24/gmaps.min.js\"></script>
\t\t
\t\t<!-- Validate js -->
\t\t<script src=\"https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.js\"></script>
\t\t
\t\t<!-- JS con scripts comunes y personalizados para el sitio web -->
\t\t<script src=\"";
        // line 149
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpFoundationExtension')->generateAbsoluteUrl($this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("assets/js/admin.js")), "html", null, true);
        echo "\"></script>

\t\t";
        // line 151
        $this->displayBlock('javascripts', $context, $blocks);
        // line 152
        echo "
\t</body>
</html>
";
    }

    // line 28
    public function block_stylesheets($context, array $blocks = array())
    {
    }

    // line 106
    public function block_body($context, array $blocks = array())
    {
    }

    // line 151
    public function block_javascripts($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  235 => 151,  230 => 106,  225 => 28,  218 => 152,  216 => 151,  211 => 149,  198 => 139,  194 => 138,  188 => 135,  182 => 132,  178 => 131,  173 => 129,  149 => 107,  147 => 106,  98 => 60,  65 => 29,  63 => 28,  55 => 23,  49 => 20,  43 => 17,  37 => 14,  22 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "base.html.twig", "D:\\xampp\\htdocs\\admin-cms\\app\\Resources\\views\\base.html.twig");
    }
}
