<?php
if(!defined("SEOSHIELD_ROOT_PATH"))define("SEOSHIELD_ROOT_PATH", rtrim(realpath(dirname(__FILE__)), "/"));

class SeoShieldModule_add_to_ititle extends seoShieldModule
{
	function add_to_ititle_rules()
	{

	}

	function ititle_cyclic_links($out_html)
	{
		// автоматическая замена циклических ссылок
        if(preg_match_all("#<a [^>]*href *= *['\"](".
    			"(https?://(www\.)?".preg_quote(ltrim($_SERVER['HTTP_HOST'],"www.")).")|".
				"(https?://(www\.)?".preg_quote(ltrim($_SERVER['HTTP_HOST'],"www.")."/".ltrim($GLOBALS['SEOSHIELD_CONFIG']['page_uri'],"/")).")|".
				"(".preg_quote(ltrim($GLOBALS['SEOSHIELD_CONFIG']['page_uri'],"/")).")|".
				"(".preg_quote($GLOBALS['SEOSHIELD_CONFIG']['page_uri']).")".
				")['\"][^>]*>(.(?!</a>))*?.?</a>#is",$out_html,$pregs)){
			foreach($pregs[0] AS $a)
			{
				$new_a=preg_replace("#(</?)a#is","\\1i",$a);
				$new_a=preg_replace("# +title *=#is"," title2=",$new_a);
				$new_a=preg_replace("# +href *=#is"," title=",$new_a);

				$out_html=str_replace($a,$new_a,$out_html);
			}
		}

		return $out_html;
	}

	function html_out_buffer($out_html)
	{
		if(isset($GLOBALS['SEOSHIELD_CONFIG']['ititle_replace_cyclic_links'])
			&& $GLOBALS['SEOSHIELD_CONFIG']['ititle_replace_cyclic_links']){
			$out_html=$this->ititle_cyclic_links($out_html);
		}

		$this->add_to_ititle_rules();

		if(isset($GLOBALS['SEOSHIELD_CONFIG']['ititle_pattern']))
		{
			foreach($GLOBALS['SEOSHIELD_CONFIG']['ititle_pattern'] AS $pattern)
			{
				if(preg_match_all($pattern,$out_html,$ititle_content,PREG_SET_ORDER)==0){
					continue;
				}

				foreach($ititle_content AS $tag)
				{
					$ititle_content_modified=str_replace("<a ","<i ",$tag[0]);
					$ititle_content_modified=str_replace("</a>","</i>",$ititle_content_modified);
					$ititle_content_modified=str_replace("title=","title2=",$ititle_content_modified);
					$ititle_content_modified=str_replace("href=","title=",$ititle_content_modified);

					$out_html=str_replace($tag[0],$ititle_content_modified,$out_html);
				}
			}
		}
		// добавляем javascript в конец документа
		if(isset($GLOBALS['SEOSHIELD_CONFIG']['ititle_add_js'])
			&& $GLOBALS['SEOSHIELD_CONFIG']['ititle_add_js']){
			if(empty($GLOBALS['SEOSHIELD_CONFIG']['ititle_js'])){
				$GLOBALS['SEOSHIELD_CONFIG']['ititle_js']=<<<EOF
<script type="text/javascript">
if(typeof jQuery=="undefined"){
	var headTag=document.getElementsByTagName("head")[0];
	var jqTag=document.createElement('script');
	jqTag.type="text/javascript";
	jqTag.src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js";
	jqTag.onload=function(){
		$.noConflict();
	};
	headTag.appendChild(jqTag);
}
jQuery(document).ready(function(){
	jQuery("i[title]").each(function(){
		var h=jQuery(this)[0].outerHTML.replace("<i ","<a ").replace("title=","href" + "=");
		h=h.replace("title2","title");
		jQuery(this)[0].outerHTML=h;
	});
});
</script>
EOF;
			}

			$out_html=str_replace("</body>",$GLOBALS['SEOSHIELD_CONFIG']['ititle_js']."</body>",$out_html);

		}

		return $out_html;
	}
}