<?php
/**
 * @package	Music
 * @subpackage	Albums
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @copyright   Copyright (C) 2009 Daniel Scott (http://danieljamesscott.org). All rights reserved. 
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.controller' );
/**
 * Album Album Controller
 *
 * @package		Joomla
 * @subpackage	Album
 * @since 1.5
 */
class MusicControllerAlbums extends JController
{
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add', 'edit' );
	}

	function display()
  	{
	  JRequest::setVar( 'model'  , 'albums');
	  JRequest::setVar( 'view'  , 'albums');
	  parent::display();
	}

	function edit()
	{
		JRequest::setVar( 'view', 'album' );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();

		// Checkin the album
		$model = $this->getModel('album');
		$model->checkout();
	}

	function save()
	{
		$post	= JRequest::get('post');
		$album_id	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$post['id'] = (int) $album_id[0];

		$model = $this->getModel('album');

		if ($model->store($post)) {
			$msg = JText::_( 'Album Saved' );
		} else {
			$msg = JText::_( 'Error Saving Album' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();
		$link = 'index.php?option=com_music&c=albums';
		$this->setRedirect($link, $msg);
	}

	function remove()
	{
		global $mainframe;

		$album_id = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($album_id);

		if (count( $album_id ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}

		$model = $this->getModel('album');
		if(!$model->delete($album_id)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_music&c=albums' );
	}


	function publish()
	{
		global $mainframe;

		$album_id = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($album_id);

		if (count( $album_id ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to publish' ) );
		}

		$model = $this->getModel('album');
		if(!$model->publish($album_id, 1)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_music&c=albums' );
	}


	function unpublish()
	{
		global $mainframe;

		$album_id = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($album_id);

		if (count( $album_id ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to unpublish' ) );
		}

		$model = $this->getModel('album');
		if(!$model->publish($album_id, 0)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_music&c=albums' );
	}

	function cancel()
	{
		// Checkin the album
		$model = $this->getModel('album');
		$model->checkin();

		$this->setRedirect( 'index.php?option=com_music&c=albums' );
	}


	function orderup()
	{
		$model = $this->getModel('album');
		$model->move(-1);

		$this->setRedirect( 'index.php?option=com_music&c=albums');
	}

	function orderdown()
	{
		$model = $this->getModel('album');
		$model->move(1);

		$this->setRedirect( 'index.php?option=com_music&c=albums');
	}

	function saveorder()
	{
		$album_id 	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order 	= JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger($album_id);
		JArrayHelper::toInteger($order);

		$model = $this->getModel('album');
		$model->saveorder($album_id, $order);

		$msg = 'New ordering saved';
		$this->setRedirect( 'index.php?option=com_music&c=albums', $msg );
	}
}
?>
