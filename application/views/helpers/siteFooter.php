<?php

class Zend_View_Helper_SiteFooter extends Zend_View_Helper_Abstract
{
     public function SiteFooter($current)
     {
         return '</div><div id="bottom">
    <div class="footer">
      &copy; Copyright <a class="discrete" href="#">MyWebSite</a>.
      Design by Dream <a class="discrete" href="http://www.dreamtemplate.com/">Web Templates</a></p>
      <div style="clear:both;"></div>
    </div>
  </div>';
     }
    
}?>
