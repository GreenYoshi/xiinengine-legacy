<?php
/**
 * XiinEngine
 *
 * * XiinEngine is supplied under the MIT license. Please read license.md  in the root directory
 *
 * @package XiinEngine Legacy
 * @author Ian Karlsson <ian.karlsson@xiinet.com>
 * @author Philip Whitehall <philip.whitehall@xiinet.com> 
 * @copyright Copyright 2006-2013 Xiin Networks <http://xiinet.com/>
 * @link http://xiinengine.com/
 * @since v1.2
 */
 
/**
 * XE Form Generator class
 *
 * More class documentation here
 */
class XeForm
{
	private $returnString;
	private $page;
	private $table;
	private $pretty;
	private $database;

	// OPENS, CLOSES AND BUTTONS
	public function __construct($dblink,$paramPage,$paramTable,$paramPretty)
	{
		$explodePage = explode('/',$paramPage);
		$this->page = sysBaseURL.'/'.$explodePage[0].'/'.'scr_'.$explodePage[1];
		$this->table = $paramTable;
		$this->pretty = $paramPretty;
		$this->database = $dblink;
	}
	
	public function __destruct()
	{
		$this->returnString = '</form>';
		return $this->returnString;
	}
	
	public function openForm()
	{
		$this->returnString = '<form enctype="multipart/form-data" action="'.$this->page.'/'.$this->pretty.'" method="post">';
		$this->returnString .= '<table class="result_list">';
		return $this->returnString;
	}
	
	public function closeTable()
	{
		$this->returnString = '</table>';
		return $this->returnString;
	}
	
	public function closeForm()
	{
		$this->returnString = '</form>';
		return $this->returnString;
	}
	
	public function buttons()
	{
		if (strpos($this->page,'edit'))
		{
			$this->returnString = '<div class="result_nav"><div class="result_nav_left"><input type="submit" class="result_button submit" name="action" value="Edit" class="button_submit_edit" /></div></div>';
		}
		else if (strpos($this->page,'add'))
		{
			$this->returnString = '<div class="result_nav"><div class="result_nav_left"><input type="submit" class="result_button submit" name="action" value="Add" class="button_submit_add" /></div></div>';
		}
		else if (strpos($this->page,'register'))
		{
			$this->returnString = '<div class="result_nav"><div class="result_nav_left"><input type="submit" class="result_button submit" name="action" value="Register" class="button_submit_add" /></div></div>';
		}
		else if (strpos($this->page,'password'))
		{
			$this->returnString = '<div class="result_nav"><div class="result_nav_left"><input type="submit" class="result_button submit" name="action" value="Set New Password" class="button_submit_add" /></div></div>';
		}
		return $this->returnString;
	}
	
	// FORM ITEMS
	public function label($label,$dbfield,$description)
	{
		$this->returnString = '<td class="result_label"><label for="'.$dbfield.'">';
		$this->returnString .= $label;
		if ($description != NULL || $description != "")
			$this->returnString .= '<br /><span class="result_help">'.$description.'</span>';
		$this->returnString .= '</label></td>';
		return $this->returnString;
	}
	
	public function readonly($dbresult)
	{
		$this->returnString = '<td class="result_editor_text">'.$dbresult.'</td>';
		return $this->returnString;
	}
	
	public function text($dbfield,$dbresult)
	{
		$this->returnString = '<td class="result_editor_text"><input type="text" name="'.$dbfield.'" size="60" value="'.$dbresult.'"></td>';
		return $this->returnString;
	}
	
	public function securityv1($dbfield,$dbresult)
	{
		$this->returnString = '<td class="result_editor_text">In the world of Nintendo, what is the name of Mario&rsquo;s brother?<br /><input type="text" name="'.$dbfield.'" size="60" value="'.$dbresult.'"></td>';
		return $this->returnString;
	}
	
	public function jquerytextarray($dbfield,$dbresult)
	{
		?>
		<script type="text/javascript">
			$(window).load(function() {	
				$(".add_textfield").css("cursor","pointer").bind('click', function() {
					$(this).siblings("div.field_clone").clone().insertBefore($(this)).attr('class','cloned');
					$(".remove_field").css("cursor","pointer").bind('click', function() {
						$(this).closest("div").remove();
					});
				});
				$(".remove_field").css("cursor","pointer").bind('click', function() {
					$(this).closest("div").remove();
				});
			});
		</script>
        <?php
		$this->returnString = '<td class="result_editor_text">
								<div class="field_clone" id="field1"><input type="text" name="'.$dbfield.'_list[]" class="'.$dbfield.'1" size="60" value="'.$dbresult.'"><span class="remove_field">Remove</span><br /></div>
								<div class="add_textfield">Add another!</div>
								</td>';
		return $this->returnString;
	}
	
	public function textarea($dbfield,$dbresult)
	{
		$this->returnString = '<td class="result_editor_text"><textarea name="'.$dbfield.'" cols="45" rows="10">'.$dbresult.'</textarea></td>';
		return $this->returnString;
	}
	
	
	public function richtext($dbfield,$dbresult)
	{
		$this->returnString = '<script type="text/javascript" src="'.sysBaseURL.'/libraries/tiny_mce/tiny_mce.js"></script>';

		// Notice: really ugly string follows:
		$this->returnString .= '
<script type="text/javascript">
tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Skin options
        skin : "o2k7",
        skin_variant : "silver",

        // Example content CSS (should be your site CSS)
        content_css : "css/example.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js",


        template_replace_values : {
                username : "'.XiinEngine::$user->Alias.'",
                staffid : "'.XiinEngine::$user->ID.'"
		}
});	
</script>
<textarea name="'.$dbfield.'" style="width:100%">'.$dbresult.'</textarea>';
			
		return $this->returnString;
	}
	
	public function truefalse($dbfield,$dbresult)
	{
		if ($dbresult == true)
			$this->returnString = '<td class="result_editor_text">True <input type="radio" name="'.$dbfield.'" value="1" checked="checked"> | False <input type="radio" name="'.$dbfield.'" value="0"></td>';
		else
			$this->returnString = '<td class="result_editor_text">True <input type="radio" name="'.$dbfield.'" value="1"> | False <input type="radio" name="'.$dbfield.'" value="0" checked="checked"></td>';
		return $this->returnString;
	}
	
	public function password($dbfield)
	{
		$this->returnString = '<td class="result_editor_text"><input type="password" name="'.$dbfield.'" size="60"></td>';
		return $this->returnString;
	}
	
	public function recaptcha()
	{
		require_once(sysLibraryPath.'recaptchalib.php');
        $publickey = "6Lev9NkSAAAAADNblZtmzAb0PiE-cFdLXxydB2yS"; // you got this from the signup page
        $this->returnString = '<td class="result_editor_text">'.recaptcha_get_html($publickey).'</td>';
		return $this->returnString;
	}
	
	public function datefield($dbfield,$dbresult)
	{
		$datefields = array("year" => NULL,"month" => NULL,"day" => NULL);
		if (!empty($dbresult))
		{
			$datefields = date_parse($dbresult);
		}
		$this->returnString = '<td class="result_editor_text">';
		$this->returnString .= 'Day: <input type="text" name="'.$dbfield.'" value="'.$datefields['day'].'" size="2">&nbsp;&nbsp;';
		$this->returnString .= 'Month: <input type="text" name="'.$dbfield.'" value="'.$datefields['month'].'" size="2">&nbsp;&nbsp;';
		$this->returnString .= 'Year: <input type="text" name="'.$dbfield.'" value="'.$datefields['year'].'" size="4">&nbsp;&nbsp;';
		$this->returnString .= '</td>';
		return $this->returnString;
	}
	
	// $dbfield is just for consistency. Fileupload doesn't actually work on a database!
	public function fileupload($dbfield,$maxfilesize)
	{
		$maxfilesize = $maxfilesize * 1024;
		
		$this->returnString = '<td class="result_editor_text">'
							. ' <input type="hidden" name="MAX_FILE_SIZE" value="'.$maxfilesize.'" />'
							. ' <input id="'.$dbfield.'" name="'.$dbfield.'" type="file" />'
							. '</td>';
		return $this->returnString;
		
	}
	
	

/*
	Format of array
	
	array(
		"Nice name" => "db_name",
	)
*/
	public function arraydropdown($dbfield,$dbresult,$options)
	{
		$this->returnString = '<td class="result_editor_text">';
		$this->returnString .= '<select id="'.$dbfield.'" name="'.$dbfield.'">';
		$this->returnString .= '<option value="NULL">Please select</option>';
		foreach($options as $name => $value)
		{
			$selected = "";
			
			if($value == $dbresult)
				$selected = 'selected="selected"';
				
			$this->returnString .= '<option value="'.$value.'" '.$selected.'>'.$name.'</option>';
		}
		$this->returnString .= '</select>';
		$this->returnString .= '</td>';
		
		return $this->returnString;
	}
	
	public function singledropdown($dbtable,$dbfield,$displayfield,$dbresult)
	{
		$this->returnString = '<td class="result_editor_text">';
		$this->returnString .= '<select id="'.$dbfield.'" name="'.$dbfield.'">';
		$this->returnString .= '<option value="NULL">Please select</option>';
		
		$dblist = $this->database->query("SELECT $dbfield, $displayfield FROM $dbtable ORDER BY $dbfield ASC") or die($this->database->error);
		
		//foreach($options as $name => $value)
		while($list = $dblist->fetch_assoc())
		{
			$name = $list[$displayfield];
			$value = $list[$dbfield];
			
			$selected = "";
			
			if($value == $dbresult)
				$selected = 'selected="selected"';
				
			$this->returnString .= '<option value="'.$value.'" '.$selected.'>'.$name.'</option>';
		}
		$this->returnString .= '</select>';
		$this->returnString .= '</td>';
		
		return $this->returnString;		
	}
	
	// AJAX ITEMS
	public function ajaxdropdown($dbtable,$dbfield,$displayfield,$dbresult)
	{
		$confirmString = 'No Existing Entries';
		$stringCounter = 0;
		$this->returnString = '<td class="result_editor_text">';
		$this->returnString .= '<select id="'.$dbfield.'_list" name="'.$dbfield.'_list[]" multiple="multiple">';
        $this->returnString .= '<option value="NULL">Please select</option>';
		if ($dbtable == "XE_PPL")
			$dblist = $this->database->query("SELECT p.PPLID AS PPLID, p.PPLAlias AS PPLAlias FROM XE_PPL p LEFT JOIN XE_PPL_Permissions plink ON plink.PPLID = p.PPLID LEFT JOIN XE_Permissions perm ON perm.PermID = plink.PermID WHERE perm.PermAccessName = 'Administrator' OR perm.PermAccessName = 'News Editor' GROUP BY PPLID ORDER BY PPLAlias ASC") or die($this->database->error);
		else
			$dblist = $this->database->query("SELECT ".$dbfield.", ".$displayfield." FROM ".$dbtable." ORDER BY ".$dbfield." ASC") or die($this->database->error);
		
		while($list = $dblist->fetch_assoc())
		{
			if (!empty($dbresult))
			{
				if (in_array($list[$dbfield],$dbresult))
				{
					$this->returnString .= '<option value="'.$list[$dbfield].'" selected="selected">'.$list[$displayfield].'</option>';
					switch ($stringCounter)
					{
						case 0:
							$confirmString = "Selected: ".$list[$displayfield];
							break;
						default:
							$confirmString .= ", ".$list[$displayfield];
							break;
					}
					$stringCounter++;
				}
				else
				{
					if ($dbtable == 'XE_Permissions')
					{
						switch ($list[$dbfield])
						{
							case 1:
								break;
							case 3:
								if ($_SESSION['xe_userID'] == 1)
									$this->returnString .= '<option value="'.$list[$dbfield].'">'.$list[$displayfield].'</option>';
								break;
							default:
								$this->returnString .= '<option value="'.$list[$dbfield].'">'.$list[$displayfield].'</option>';
						}
					}
					else
						$this->returnString .= '<option value="'.$list[$dbfield].'">'.$list[$displayfield].'</option>';
				}
			}
			else
			{
				if ($dbtable == 'XE_Permissions')
				{
					switch ($list[$dbfield])
					{
						case 1:
							break;
						case 3:
							if ($_SESSION['xe_userID'] == 1)
								$this->returnString .= '<option value="'.$list[$dbfield].'">'.$list[$displayfield].'</option>';
							break;
						default:
							$this->returnString .= '<option value="'.$list[$dbfield].'">'.$list[$displayfield].'</option>';
					}
				}
				else
					$this->returnString .= '<option value="'.$list[$dbfield].'">'.$list[$displayfield].'</option>';
			}
		}
		$this->returnString .= '</select>';
		$this->returnString .= '<div id="'.$dbfield.'_selected" name="'.$dbfield.'_selected">'.$confirmString.'</div>';
		$this->returnString .= '<script language="javascript" type="text/javascript">';
		$this->returnString .= '$("#'.$dbfield.'_list").change(function(){';
		$this->returnString .= 'var str = "";';
		$this->returnString .= '$("select option:selected").each(function () {';
		$this->returnString .= 'str += $(this).text() + ", ";';
		$this->returnString .= '});';
		$this->returnString .= '$("#'.$dbfield.'_selected").text("Selected: " + str);';
    	$this->returnString .= '});';
		$this->returnString .= '</script>';
		$this->returnString .= '</td>';
		
		return $this->returnString;
	}
	
	public function ajaxsingledropdown($dbtable,$dbfield,$displayfield,$dbresult)
	{
		$confirmString = 'No Existing Entries';
		$stringCounter = 0;
		$this->returnString = '<td class="result_editor_text">';
		$this->returnString .= '<select id="'.$dbfield.'" name="'.$dbfield.'">';
        $this->returnString .= '<option value="NULL">Please select</option>';
		if ($dbtable == "XE_PPL")
			$dblist = $this->database->query("SELECT p.PPLID AS PPLID, p.PPLAlias AS PPLAlias FROM XE_PPL p LEFT JOIN XE_PPL_Permissions plink ON plink.PPLID = p.PPLID LEFT JOIN XE_Permissions perm ON perm.PermID = plink.PermID WHERE perm.PermAccessName = 'Administrator' OR perm.PermAccessName = 'News Editor' GROUP BY PPLID ORDER BY PPLAlias ASC") or die($this->database->error);
		else
			$dblist = $this->database->query("SELECT ".$dbfield.", ".$displayfield." FROM ".$dbtable." ORDER BY ".$dbfield." ASC") or die($this->database->error);
		
		while($list = $dblist->fetch_assoc())
		{
			if (!empty($dbresult))
			{
				if (in_array($list[$dbfield],$dbresult))
				{
					$this->returnString .= '<option value="'.$list[$dbfield].'" selected="selected">'.$list[$displayfield].'</option>';
					switch ($stringCounter)
					{
						case 0:
							$confirmString = "Selected: ".$list[$displayfield];
							break;
						default:
							$confirmString .= ", ".$list[$displayfield];
							break;
					}
					$stringCounter++;
				}
				else
				{
					if ($dbtable == 'XE_Permissions')
					{
						switch ($list[$dbfield])
						{
							case 1:
								break;
							case 3:
								if ($_SESSION['xe_userID'] == 1)
									$this->returnString .= '<option value="'.$list[$dbfield].'">'.$list[$displayfield].'</option>';
								break;
							default:
								$this->returnString .= '<option value="'.$list[$dbfield].'">'.$list[$displayfield].'</option>';
						}
					}
					else
						$this->returnString .= '<option value="'.$list[$dbfield].'">'.$list[$displayfield].'</option>';
				}
			}
			else
			{
				if ($dbtable == 'XE_Permissions')
				{
					switch ($list[$dbfield])
					{
						case 1:
							break;
						case 3:
							if ($_SESSION['xe_userID'] == 1)
								$this->returnString .= '<option value="'.$list[$dbfield].'">'.$list[$displayfield].'</option>';
							break;
						default:
							$this->returnString .= '<option value="'.$list[$dbfield].'">'.$list[$displayfield].'</option>';
					}
				}
				else
					$this->returnString .= '<option value="'.$list[$dbfield].'">'.$list[$displayfield].'</option>';
			}
		}
		$this->returnString .= '</select>';
		$this->returnString .= '</td>';
		
		return $this->returnString;
	}
	
	public function select2_single($dbfield,$dbresult,$apiname)
	{
		$this->returnString = '<script type="text/javascript" src="'.sysBaseURL.'/libraries/tiny_mce/tiny_mce.js"></script>';

		// Notice: really ugly string follows:
		$this->returnString .= '
<script type="text/javascript">
$(document).ready(function() {
	$("#'.$dbfield.'").select2({
        placeholder: "Start typing...",
        ajax: {
            url: "'.sysBaseUrl.'/api/'.$apiname.'",
            dataType: "json",
            quietMillis: 100,
            data: function (term, page) {
                return {
                    term: term, //search term
                    page_limit: 10, // page size
					page: page // page number
                };
            },
            results: function (data, page) {
				var more = (page * 10) < data.total;
                return { results: data.results, more: more };
            }

        },
        initSelection: function(element, callback) {
            return $.getJSON("'.sysBaseUrl.'/api/'.$apiname.'?id=" + (element.val()), null, function(data) {

                    return callback(data);

            });
        }

    });
});
</script>
<input type="hidden" name="'.$dbfield.'" id="'.$dbfield.'" style="width:100%" value="'.$dbresult.'" />';
			
		return $this->returnString;
	}
	
	// ROW GENERATOR
	public function row($label,$description,$editorType,$dbfield,$dbresult,$options = null,$options2 = null)
	{
		switch ($editorType)
		{
			case 'richtext': // when rows need to exit the standard table structure
				$rowOutput = '</table>';
				$rowOutput .= $this->richtext($dbfield,$dbresult);
				$rowOutput .= '<table class="result_list">';
				break;
			default:
				$rowOutput = '<tr class="table_row">';
				$rowOutput .= $this->label($label,$dbfield,$description);
				switch ($editorType)
				{
					case 'readonly':
						$rowOutput .= $this->readonly($dbresult);
						break;
					case 'text':
						$rowOutput .= $this->text($dbfield,$dbresult);
						break;
					case 'textarray':
						$rowOutput .= $this->jquerytextarray($dbfield,$dbresult);
						break;
					case 'textarea':
						$rowOutput .= $this->textarea($dbfield,$dbresult);
						break;
					case 'password':
						$rowOutput .= $this->password($dbfield);
						break;
					case 'bool':
						$rowOutput .= $this->truefalse($dbfield,$dbresult);
						break;
					case 'dropdown':
						$rowOutput .= $this->arraydropdown($dbfield,$dbresult,$options);
						break;
					case 'date':
						$rowOutput .= $this->datefield($dbfield,$dbresult);
						break;
					// USAGE: row($label,$description,'singledropdown',$dbfield,$dbresult,$dbtable,$displayfield);
					case 'singledropdown':
						$rowOutput .= $this->singledropdown($options,$dbfield,$options2,$dbresult);
						break;
					// USAGE: row($label,$description,'fileupload',$dbfield,'',$maxfilesize);
					case 'fileupload':
						$rowOutput .= $this->fileupload($dbfield,$options);	
						break;
					// USAGE: row($label,$description,'select2_single',$dbfield,$dbresult,$apiname); (apiname example: 'pplselect')
					case 'select2_single':
						$rowOutput .= $this->select2_single($dbfield,$dbresult,$options);
						break;
					case 'recaptcha':
						$rowOutput .= $this->recaptcha();
						break;
					case 'securityv1':
						$rowOutput .= $this->securityv1($dbfield,$dbresult);
						break;
					default:
						break;
				}
				$rowOutput .= '</tr>';
				break;
		}
		
		return $rowOutput;
	}
	
	public function ajaxrow($label,$description,$editorType,$dbtable,$dbfield,$displayfield,$dbresult)
	{
		$rowOutput = '<tr class="table_row">';
		$rowOutput .= $this->label($label,$dbfield,$description);
		switch ($editorType)
		{
			case 'dropdown':
				$rowOutput .= $this->ajaxdropdown($dbtable,$dbfield,$displayfield,$dbresult);
				break;
			case 'dropdownsingle':
				$rowOutput .= $this->ajaxsingledropdown($dbtable,$dbfield,$displayfield,$dbresult);
				break;
			default:
				break;
		}
		$rowOutput .= '</tr>';
		return $rowOutput;
	}

}

?>

