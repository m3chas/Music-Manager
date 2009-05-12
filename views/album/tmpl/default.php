<?php defined( '_JEXEC' ) or die(); ?>
<div class="componentheading<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
<?php if ($this->album->name) :
	echo $this->params->get('page_title').' - '.$this->album->name;
else :
	echo $this->params->get('page_title');
endif; ?>
</div>
<div class="contentpane<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tbody>
<tr>
<td>
<ol>
<?php foreach($this->items as $item) : ?>
<li>
<a href="images/songs/<?php echo $item->mp3; ?>" ><?php echo $item->name; ?></a>
</li>
<?php endforeach; ?>
</ol>
</td>
<td align="right">
<?php if ($this->params->get('show_albumart_front')) { ?>
<?php if ($this->album->albumart_front == "") {
  print "No front album art available";
} else { ?>
<img src="images/albumart/<?php echo $this->album->albumart_front; ?>" align="<?php echo $this->params->get('image_align'); ?>" hspace="6" height="200px" width="200px" alt="<?php echo $this->album->name . ' ' . JText::_( 'Front Albumart' ); ?>" />
<?php } ?>
<?php } ?>
</td>
</tr>
<tr>
<td align="left">
<?php echo nl2br($this->album->description); ?>
</td>
<td align="right">
<?php print $this->params->get('show_albumart_back'); ?>
<?php if ($this->params->get('show_albumart_back')) { ?>
<?php if ($this->album->albumart_back == "") {
  print "No back album art available";
} else { ?>
 <img src="images/albumart/<?php echo $this->album->albumart_back; ?>" align="<?php echo $this->params->get('image_align'); ?>" hspace="6" height="200px" width="200px" alt="<?php echo $this->album->name . ' ' . JText::_( 'Back Albumart' ); ?>" />
<?php } ?>
<?php } ?>
</td>
</tr>
</tbody>
</table>

<input type="hidden" name="option" value="com_music" />
<input type="hidden" name="albumid" value="<?php echo $this->album->id;?>" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="" />
</form>
</div>