<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT

   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  class ht_googlebot
  {
    public string $code;
    public $group;
    public $title;
    public $description;
    public ?int $sort_order = 0;
    public bool $enabled = false;
    public array $languages_array = [];

    public function __construct()
    {
      $this->code = get_class($this);
      $this->group = basename(__DIR__);

      $this->title = CLICSHOPPING::getDef('module_header_tags_googlebot_title');
      $this->description = CLICSHOPPING::getDef('module_header_tags_googlebot_description');

      if (\defined('MODULE_HEADER_TAGS_GOOGLEBOT_STATUS')) {
        $this->sort_order = MODULE_HEADER_TAGS_GOOGLEBOT_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_TAGS_GOOGLEBOT_STATUS == 'True');
      }
    }

    public function execute()
    {

      $CLICSHOPPING_Template = Registry::get('Template');

      $tag_array = [];
      if (MODULE_HEADER_TAGS_GOOGLEBOT_NOINDEX == 'True') $tag_array[] = 'noindex';
      if (MODULE_HEADER_TAGS_GOOGLEBOT_NOFOLLOW == 'True') $tag_array[] = 'nofollow';
      if (MODULE_HEADER_TAGS_GOOGLEBOT_NOSNIPPET == 'True') $tag_array[] = 'nosnippit';
      if (MODULE_HEADER_TAGS_GOOGLEBOT_NOODP == 'True') $tag_array[] = 'noodp';
      if (MODULE_HEADER_TAGS_GOOGLEBOT_NOARCHIVE == 'True') $tag_array[] = 'noarchive';
      if (MODULE_HEADER_TAGS_GOOGLEBOT_NOIMAGEINDEX == 'True') $tag_array[] = 'noimageindex';

      if (\count($tag_array) > 0) {
        $tag_string = implode(',', $tag_array);
        $meta_tag = '<meta name="googlebot" content="' . $tag_string . '">';

        $CLICSHOPPING_Template->addBlock($meta_tag, $this->group);
      }
    }

    public function isEnabled()
    {
      return $this->enabled;
    }

    public function check()
    {
      return \defined('MODULE_HEADER_TAGS_GOOGLEBOT_STATUS');
    }

    public function install()
    {
      $CLICSHOPPING_Db = Registry::get('Db');

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Do you want to install this module ?',
          'configuration_key' => 'MODULE_HEADER_TAGS_GOOGLEBOT_STATUS',
          'configuration_value' => 'True',
          'configuration_description' => 'Do you want to install this module ?',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'True\', \'False\'))',
          'date_added' => 'now()'
        ]
      );


      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Souhaitez-vous activer la meta Noindex Tag',
          'configuration_key' => 'MODULE_HEADER_TAGS_GOOGLEBOT_NOINDEX',
          'configuration_value' => 'False',
          'configuration_description' => 'Si vous activez cette meta, votre site ne sera pas indexé',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'True\', \'False\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Souhaitez-vous activer la meta Nofollow ?',
          'configuration_key' => 'MODULE_HEADER_TAGS_GOOGLEBOT_NOFOLLOW',
          'configuration_value' => 'False',
          'configuration_description' => 'Si vous activez cette meta, vos liens ne seront pas suivis.',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'True\', \'False\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Souhaitez-vous activer la meta Nosnippit ?',
          'configuration_key' => 'MODULE_HEADER_TAGS_GOOGLEBOT_NOSNIPPET',
          'configuration_value' => 'False',
          'configuration_description' => 'Si vous activez cette meta, la description du contenu de la page, qui s\'affiche sous le titre d\'une page dans nos résultats de recherche ne sera pas pris en compte.',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'True\', \'False\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Souhaitez-vous activer la meta NoODP ?',
          'configuration_key' => 'MODULE_HEADER_TAGS_GOOGLEBOT_NOODP',
          'configuration_value' => 'False',
          'configuration_description' => 'Si vous activez cette meta, votre contenu ne sera pas référenc&Eacute; dans l\'open directory DMOZ.',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'True\', \'False\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Souhaitez-vous activer la meta Noarchive ?',
          'configuration_key' => 'MODULE_HEADER_TAGS_GOOGLEBOT_NOARCHIVE',
          'configuration_value' => 'False',
          'configuration_description' => 'Si vous activez cette meta, votre contenu ne sera pas archivé',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'True\', \'False\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Souhaitez-vous activer la meta Noimageindex ?',
          'configuration_key' => 'MODULE_HEADER_TAGS_GOOGLEBOT_NOIMAGEINDEX',
          'configuration_value' => 'False',
          'configuration_description' => 'Si vous activez cette meta, google image ne tiendra pas compte de la redirection vers votre site.',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'True\', \'False\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Sort Order',
          'configuration_key' => 'MODULE_HEADER_TAGS_GOOGLEBOT_SORT_ORDER',
          'configuration_value' => '110',
          'configuration_description' => 'Sort order. Lowest is displayed in first',
          'configuration_group_id' => '6',
          'sort_order' => '90',
          'set_function' => '',
          'date_added' => 'now()'
        ]
      );
    }

    public function remove()
    {
      return Registry::get('Db')->exec('delete from :table_configuration where configuration_key in ("' . implode('", "', $this->keys()) . '")');
    }

    public function keys()
    {
      $keys_array = array();

      $keys_array[] = 'MODULE_HEADER_TAGS_GOOGLEBOT_STATUS';
      $keys_array[] = 'MODULE_HEADER_TAGS_GOOGLEBOT_NOINDEX';
      $keys_array[] = 'MODULE_HEADER_TAGS_GOOGLEBOT_NOFOLLOW';
      $keys_array[] = 'MODULE_HEADER_TAGS_GOOGLEBOT_NOSNIPPET';
      $keys_array[] = 'MODULE_HEADER_TAGS_GOOGLEBOT_NOODP';
      $keys_array[] = 'MODULE_HEADER_TAGS_GOOGLEBOT_NOARCHIVE';
      $keys_array[] = 'MODULE_HEADER_TAGS_GOOGLEBOT_NOIMAGEINDEX';
      $keys_array[] = 'MODULE_HEADER_TAGS_GOOGLEBOT_SORT_ORDER';

      return $keys_array;
    }
  }
