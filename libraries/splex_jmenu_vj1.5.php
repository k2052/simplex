<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// ------------------------------------------------------------------------

/**
 * Menu Class. Just Generates A Menu. Most of the cool stuff happens in the over-ride.      
 *
 * @note This is now called jMenu because its only going to be used for the Joomla! mainmenu module.
 *  I'm rolling a custom built menu module vary soon that will integrate with Simplex.
 * 
 * @package     simplex
 * @subpackage  libraries
 * @version     1.0 beta 
 * @author      Ken Erickson AKA Bookworm http://www.bookwormproductions.net
 * @copyright   Copyright 2009 - 2011 Design BreakDown, LLC.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2       
 * please visit the Simplex site http://www.simplex.designbreakdown.com  for support. 
 * Do not e-mail (or god forbid IM or call) me directly.
 */
class Splex_JMenu 
{        
  /**
   * Menu Creation Function.
   *
   * @param string $menuType  Specify the type of Joomla! Menu. e.g MainMenu.
   * @param string $menuName  The name of the menu to render    
   * @param string $type      The type of menu to render. Refers to markup and not Joomla! Menu Type.
   *                          Options; Dropdown. More options coming soon.      
   * @param string $menuClass A class to add to the menu. Optional.
   */
  function createMenu($menuType, $menuName, $type = 'dropdown', $menuClass = null, $menuID = null)
  { 
    jimport( 'joomla.application.module.helper' );
    
    $splex    =& getSplexInstance();  
    $document =& JFactory::getDocument();       
              
    if($type == 'dropdown')
    {   
      $renderer         = $document->loadRenderer( 'module' ); 
      $menu             = Splex_Modules::getModule($menuType, $menuName);
      $menuParams       = new JParameter( $menu->params );      
      $menuClass        = $menuClass . ' ' . $menuParams->get( 'class_sfx' ); 
      $menuId           = $menuID . ' ' . $menuParams->get( 'tag_id' );
      $menu->params     = "showAllChildren=1\ntag_id=" . $menuID . "\nclass_sfx=" . ' dropdown ' . $menuClass;
      $attribs['style'] = 'raw';                                                                          
      echo $renderer->render($menu, $attribs);                                                  
    }                                                                                                                                                                                                              
    else                                                                                                    
    {                                                                                                       
      $renderer         = $document->loadRenderer( 'module' );                                                  
      $menu             = Splex_Modules::getModule($menuType, $menuName);                                            
      $menuParams       = new JParameter( $menu->params );                                                      
      $menuClass        = $menuClass . ' ' . $menuParams->get( 'class_sfx' );                                    
      $menuId           = $menuID . ' ' . $menuParams->get( 'tag_id' );                                             
      $menu->params     = "showAllChildren=1\ntag_id=" . $menuID . "\nclass_sfx=" . ' dropdown ' . $menuClass;
      $attribs['style'] = 'raw';            
      echo $renderer->render($menu, $attribs);  
    }  
  }
}