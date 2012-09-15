<?php
// auto-generated by sfDefineEnvironmentConfigHandler
// date: 2011/11/17 22:09:59
sfConfig::add(array(
  'app_a_page_cache_lifetime' => 3600,
  'app_a_page_cache_class' => 'sfFileCache',
  'app_a_page_cache_options' => array (
  'cache_dir' => '/home/hormigon/usvn/files/checkout/parquelareja/data/a_writable/a_page_cache',
),
  'app_a_googleAnalytics' => array (
  'account' => 'UA-25028261-1',
),
  'app_a_vimeo' => array (
  'oauthConsumerKey' => 'dd100f6d59a48aa380eae435c66fbced',
  'oauthConsumerSecret' => 'dd5fc21d236e2f89',
),
  'app_a_personal_settings_enabled' => false,
  'app_a_global_button_order' => array (
  0 => 'blog',
  1 => 'calendario',
  2 => 'media',
  3 => 'users',
  4 => 'reorganize',
),
  'app_a_i18n_switch' => false,
  'app_a_login_link' => false,
  'app_a_i18n_languages' => array (
  0 => 'es',
),
  'app_a_routes_register' => false,
  'app_a_default_on' => true,
  'app_a_pretty_english_dates' => false,
  'app_a_persistent_global_toolbar' => false,
  'app_a_manage_candidate_group' => 'editor',
  'app_a_manage_sufficient_group' => 'admin',
  'app_a_edit_candidate_group' => 'editor',
  'app_a_edit_sufficient_group' => 'admin',
  'app_a_view_locked_sufficient_credentials' => 'view_locked',
  'app_a_max_page_levels' => 3,
  'app_a_max_children_per_page' => 8,
  'app_a_max_page_limit_message' => 'Cannot create a child page here.',
  'app_a_addslot_button_style' => 'big',
  'app_a_history_button_style' => 'no-label big',
  'app_a_delete_button_style' => 'no-label',
  'app_a_slot_types' => array (
  'aBlog' => 'Blog Posts',
  'aBlogSingle' => 'Blog Post',
  'aEvent' => 'Events',
  'aEventSingle' => 'Event',
  'fSnapShot' => 'SnapShot',
  'aPDF' => 'PDF',
),
  'app_a_slot_variants' => array (
  'aButton' => 
  array (
    'normal' => 
    array (
      'label' => 'Normal',
    ),
    'useTitleAsButtonText' => 
    array (
      'label' => 'Text Over',
    ),
  ),
  'aSlideshow' => 
  array (
    'normal' => 
    array (
      'label' => 'Normal',
      'options' => 
      array (
        'interval' => 0,
        'title' => false,
        'arrows' => true,
      ),
    ),
    'compact' => 
    array (
      'label' => 'Compact',
      'options' => 
      array (
        'interval' => 0,
        'title' => true,
        'arrows' => true,
        'itemTemplate' => 'slideshowItemCompact',
      ),
    ),
    'autoplay' => 
    array (
      'label' => 'Auto Play',
      'options' => 
      array (
        'interval' => 4,
        'title' => true,
        'arrows' => false,
        'itemTemplate' => 'slideshowItemCompact',
      ),
    ),
  ),
),
  'app_a_home_as_tab' => true,
  'app_a_templates' => array (
  'home' => 'Home Page',
  'default' => 'Default Page',
  'simple' => 'Simple',
  'actividades' => 'Actividades con Calendario',
),
  'app_a_use_bundled_layout' => false,
  'app_a_engines' => array (
  '' => 'Template-Based',
  'aBlog' => 'Blog',
  'aEvent' => 'Events',
  'aMedia' => 'Media',
  'contacto' => 'Contacto',
  'calendario' => 'Calendario',
  'reserva' => 'Reserva',
),
  'app_a_page_cache_enabled' => true,
  'app_a_minify' => true,
  'app_a_minify_gzip' => false,
  'app_aAdmin_web_dir' => '/apostrophePlugin',
  'app_aMedia_client_apikey' => 'dummy',
  'app_aMedia_apikeys' => array (
  0 => 'dummy',
),
  'app_aMedia_apipublic' => false,
  'app_aMedia_admin_credential' => 'media_admin',
  'app_aMedia_upload_credential' => 'media_upload',
  'app_aMedia_use_bundled_layout' => false,
  'app_aMedia_embed_codes' => true,
  'app_aMedia_embed_services' => array (
  0 => 
  array (
    'class' => 'aYoutube',
    'media_type' => 'video',
  ),
  1 => 
  array (
    'class' => 'aVimeo',
    'media_type' => 'video',
  ),
  2 => 
  array (
    'class' => 'aPicasa',
    'media_type' => 'image',
  ),
),
  'app_aToolkit_indexes' => array (
  0 => 'aPage',
  1 => 'aMediaItem',
),
  'app_sfSyncContent_content' => array (
  0 => 'web/uploads',
  1 => 'data/a_writable',
),
  'app_aimageconverter_path' => '/opt/local/bin',
  'app_cli_host' => 'parquelareja',
));
