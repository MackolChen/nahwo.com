<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="renderer"  content="webkit">
  <title>PbootCMS管理中心-V<?php echo APP_VERSION;?>-<?php echo RELEASE_TIME;?></title>
  <link rel="shortcut icon" href="<?php echo SITE_DIR;?>/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo APP_THEME_DIR;?>/layui/css/layui.css?v=v2.5.4">
  <link rel="stylesheet" href="<?php echo APP_THEME_DIR;?>/font-awesome/css/font-awesome.min.css?v=v4.7.0" type="text/css">
  <link rel="stylesheet" href="<?php echo APP_THEME_DIR;?>/css/comm.css?v=v2.0.0">
  <link href="<?php echo APP_THEME_DIR;?>/css/jquery.treetable.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/js/jquery-1.12.4.min.js"></script>
  <script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/js/jquery.treetable.js"></script>
</head>

<body class="layui-layout-body">

<!--定义部分地址方便JS调用-->
<div style="display: none">
	<span id="controller" data-controller="<?php echo C;?>"></span>
	<span id="url" data-url="<?php echo URL;?>"></span>
	<span id="preurl" data-preurl="<?php echo url('/admin',false);?>"></span>
	<span id="sitedir" data-sitedir="<?php echo SITE_DIR;?>"></span>
	<span id="mcode" data-mcode="<?php echo get('mcode');?>"></span>
</div>

<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo">
    <a href="<?php echo \core\basic\Url::get('/admin/Index/home');?>">
    <img src="<?php echo APP_THEME_DIR;?>/images/logo.png" height="30">
    PbootCMS
    </a>
    </div>
    
    <ul class="menu">
    	<li class="menu-ico" title="显示或隐藏侧边栏"><i class="fa fa-bars" aria-hidden="true"></i></li>
	</ul>
	<?php if (!$this->getVar('one_area')) {?>
	<form method="post" action="<?php echo \core\basic\Url::get('/admin/Index/area');?>" class="area-select">
		<input type="hidden" name="formcheck" value="<?php echo $this->getVar('formcheck');?>" > 
		<div class="layui-col-xs8">
		   <select name="acode">
		       <?php echo $this->getVar('area_html');?>
		   </select>
		</div>
		<div class="layui-col-xs4">
		 	<button type="submit" class="layui-btn layui-btn-sm">切换</button>
		</div>
   	</form>
 	<?php } ?>

    <ul class="layui-nav layui-layout-right">
    
       <li class="layui-nav-item layui-hide-xs">
      	 <a href="<?php echo SITE_DIR;?>/" target="_blank"><i class="fa fa-home" aria-hidden="true"></i> 网站主页</a>
       </li>

       <li class="layui-nav-item layui-hide-xs">
       		<a href="<?php echo \core\basic\Url::get('/admin/Index/clearCache');?>"><i class="fa fa-trash-o" aria-hidden="true"></i> 清理缓存</a>
       </li>
       
       <?php if ($this->getVar('one_area')) {?>
	       	<li class="layui-nav-item">
	       		<a href="<?php echo \core\basic\Url::get('/admin/Index/loginOut');?>"><i class="fa fa-sign-out" aria-hidden="true"></i> 退出登录</a>
	       	</li>
       <?php } else { ?>
	       	<li class="layui-nav-item layui-hide-xs">
	       		<a href="<?php echo \core\basic\Url::get('/admin/Index/loginOut');?>"><i class="fa fa-sign-out" aria-hidden="true"></i> 退出登录</a>
	       	</li>
       <?php } ?>
       <li class="layui-nav-item layui-hide-xs">
	        <a href="javascript:;">
	          <i class="fa fa-user-circle-o" aria-hidden="true"></i> <?php echo session('realname');?>
	        </a>
	        <dl class="layui-nav-child">
	          <dd><a href="<?php echo \core\basic\Url::get('/admin/Index/ucenter');?>"><i class="fa fa-address-card-o" aria-hidden="true"></i> 资料修改</a></dd>
	        </dl>
      </li>
    </ul>
  </div>
  
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree" id="nav" lay-shrink="all">
	   <?php $num = 0;foreach ($this->getVar('menu_tree') as $key => $value) { $num++;?>
        <li class="layui-nav-item nav-item <?php if ($this->getVar('primary_menu_url')==$value->url) {?>layui-nav-itemed<?php } ?>">
          <a class="" href="javascript:;"><i class="fa <?php echo $value->ico; ?>" aria-hidden="true"></i><?php echo $value->name; ?></a>
          <dl class="layui-nav-child">
			<?php if ($value->mcode=='M130') {?>
				 <?php $num3 = 0;foreach ($this->getVar('menu_models') as $key3 => $value3) { $num3++;?>
				 	<?php if ($value3->type==1) {?>
						<dd><a href="<?php echo \core\basic\Url::get('/admin/Single/index/mcode/'.$value3->mcode.'');?>"><i class="fa fa-file-text-o" aria-hidden="true"></i><?php echo $value3->name; ?>内容</a></dd>
					<?php } ?>
					<?php if ($value3->type==2) {?>
						<dd><a href="<?php echo \core\basic\Url::get('/admin/Content/index/mcode/'.$value3->mcode.'');?>"><i class="fa fa-file-text-o" aria-hidden="true"></i><?php echo $value3->name; ?>内容</a></dd>
					<?php } ?>
				 <?php } ?>
			<?php } else { ?>
				<?php $num2 = 0;foreach ($value->son as $key2 => $value2) { $num2++;?>
					<?php if (!isset($value2->status)|| $value2->status==1) {?>
	            		<dd><a href="<?php echo \core\basic\Url::get(''.$value2->url.'');?>"><i class="fa <?php echo $value2->ico; ?>" aria-hidden="true"></i><?php echo $value2->name; ?></a></dd>
	            	<?php } ?>
				<?php } ?>
				
				<?php if ($value->mcode=='M101' && session('ucode')==10001) {?>
					<dd><a href="<?php echo \core\basic\Url::get('/admin/Upgrade/index');?>"><i class="fa fa-cloud-upload" aria-hidden="true"></i>在线更新</a></dd>
				<?php } ?>
		    <?php } ?>
          </dl>
        </li>
		<?php } ?>
		
		<li style="height:1px;background:#666" class="layui-hide-sm"></li>
		
		<li class="layui-nav-item layui-hide-sm">
          <a href="<?php echo \core\basic\Url::get('/admin/Index/ucenter');?>"><i class="fa fa-address-card-o" aria-hidden="true"></i> 资料修改</a>
        </li>
        
        <li class="layui-nav-item layui-hide-sm">
         <a href="<?php echo \core\basic\Url::get('/admin/Index/clearCache');?>"><i class="fa fa-trash-o" aria-hidden="true"></i> 清理缓存</a>
        </li>
        
        <?php if (!$this->getVar('one_area')) {?>
        <li class="layui-nav-item layui-hide-sm">
         <a href="<?php echo \core\basic\Url::get('/admin/Index/loginOut');?>"><i class="fa fa-sign-out" aria-hidden="true"></i> 退出登录</a>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>

<div class="layui-body">

	<?php if ($this->getVar('list')) {?>
	<div class="layui-tab layui-tab-brief" lay-filter="tab">
	  <ul class="layui-tab-title">
	    <li class="layui-this" lay-id="t1">标签内容</li>
	    <li lay-id="t2">标签管理</li>
	    <li lay-id="t3">新增标签</li>
	  </ul>
	  <div class="layui-tab-content">
	  	<div class="layui-tab-item layui-show">
	  		<form action="<?php echo \core\basic\Url::get('/admin/Label/index');?>" method="post" class="layui-form">
	  			<input type="hidden" name="formcheck" value="<?php echo $this->getVar('formcheck');?>" > 
	  			<?php $num = 0;foreach ($this->getVar('labels') as $key => $value) { $num++;?>
	  				<?php if ($value->type==1) {?> <!-- 文本 -->
		                <div class="layui-form-item">
		                     <label class="layui-form-label"><?php echo $value->description; ?><br><span class="layui-badge layui-bg-gray">{label:<?php echo $value->name; ?>}</span></label>
		                     <div class="layui-input-block">
		                     	<input type="text" name="<?php echo $value->name; ?>" value="<?php echo $value->value; ?>" placeholder="请输入<?php echo $value->description; ?>"  class="layui-input">
		                     </div>
		                </div>
	                <?php } ?>
	                
	                <?php if ($value->type==2) {?><!-- 日期 -->
	                	 <div class="layui-form-item">
		                     <label class="layui-form-label"><?php echo $value->description; ?><br><span class="layui-badge layui-bg-gray">{label:<?php echo $value->name; ?>}</span></label>
		                     <div class="layui-input-block">
		                     	<input type="text" name="<?php echo $value->name; ?>" readonly value="<?php echo $value->value; ?>" placeholder="请选择<?php echo $value->description; ?>"  class="layui-input datetime">
		                     </div>
		                </div>
	                <?php } ?>
	                
	                <?php if ($value->type==3) {?><!-- 图片 -->
	                	<div class="layui-form-item">
		                     <label class="layui-form-label"><?php echo $value->description; ?><br><span class="layui-badge layui-bg-gray">{label:<?php echo $value->name; ?>}</span></label>
		                     <div class="layui-input-inline">
		                     	<input type="text" name="<?php echo $value->name; ?>" id="<?php echo $value->name; ?>" value="<?php echo $value->value; ?>" placeholder="请上传<?php echo $value->description; ?>"  class="layui-input">
		                     </div>
		                     <button type="button" class="layui-btn upload" data-des="<?php echo $value->name; ?>">
							 	 <i class="layui-icon">&#xe67c;</i>上传图片
							 </button>
							 <div id="<?php echo $value->name; ?>_box" class="pic"><?php if ($value->value) {?><dl><dt><img src="<?php echo SITE_DIR;?><?php echo $value->value; ?>" data-url="<?php echo $value->value; ?>"></dt><dd>删除</dd></dl><?php } ?></div>
		                </div>
	                <?php } ?>
	                
	                <?php if ($value->type==4) {?><!-- 文件 -->
	                	<div class="layui-form-item">
		                     <label class="layui-form-label"><?php echo $value->description; ?><br><span class="layui-badge layui-bg-gray">{label:<?php echo $value->name; ?>}</span></label>
		                     <div class="layui-input-inline">
		                     	<input type="text" name="<?php echo $value->name; ?>" id="<?php echo $value->name; ?>" value="<?php echo $value->value; ?>" placeholder="请上传<?php echo $value->description; ?>"  class="layui-input">
		                     </div>
		                     <button type="button" class="layui-btn file" data-des="<?php echo $value->name; ?>">
							 	 <i class="layui-icon">&#xe67c;</i>上传文件
							 </button>
		                </div>
	                <?php } ?>
	                
	                <?php if ($value->type==5) {?><!-- 编辑器 -->
	                	<div class="layui-form-item">
		                     <label class="layui-form-label"><?php echo $value->description; ?><br><span class="layui-badge layui-bg-gray">{label:<?php echo $value->name; ?>}</span></label>
		                     <div class="layui-input-block">
		                     	<script type="text/plain" id="<?php echo $value->name; ?>" name="<?php echo $value->name; ?>" style="width:100%;height:240px;"><?php echo decode_string($value->value);?></script>
		                     </div>
		                </div>
		                <script>
							//初始化编辑器
							$(document).ready(function (e) {
								var ue = UE.getEditor('<?php echo $value->name; ?>',{
									maximumWords:500 
								});
							})
						</script>
	                <?php } ?>
	                
	                <?php if ($value->type==6) {?> <!-- 开关 -->
		                <div class="layui-form-item">
		                     <label class="layui-form-label"><?php echo $value->description; ?><br><span class="layui-badge layui-bg-gray">{label:<?php echo $value->name; ?>}</span></label>
		                     <div class="layui-input-block">
		                     	<input type="radio" name="<?php echo $value->name; ?>" value="1" title="开启" <?php if ($value->value) {?>checked<?php } ?>>
      							<input type="radio" name="<?php echo $value->name; ?>" value="0" title="关闭" <?php if (!$value->value) {?>checked<?php } ?>>
		                     </div>
		                </div>
	                <?php } ?>
	                
	                <?php if ($value->type==7) {?> <!-- 多行文本 -->
		                <div class="layui-form-item">
		                     <label class="layui-form-label"><?php echo $value->description; ?><br><span class="layui-badge layui-bg-gray">{label:<?php echo $value->name; ?>}</span></label>
		                     <div class="layui-input-block">
		                     	<textarea name="<?php echo $value->name; ?>" class="layui-textarea" placeholder="请输入<?php echo $value->description; ?>"><?php echo str_replace("<br>","\r\n",html_entity_decode($value->value));?></textarea>
		                     </div>
		                </div>
	                <?php } ?>
	                
	  			<?php } ?>
	  			<div class="layui-form-item">
					 <div class="layui-input-block">
					    <button class="layui-btn" lay-submit>立即提交</button>
					    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
					 </div>
				</div>
	  		</form>
	  	</div>
	  	
	  	<div class="layui-tab-item">
	  		<table class="layui-table">
            	<thead>
                    <tr>
                        <th>序号</th>
                        <th>名称</th>
                        <th>描述</th>
                        <th>类型</th>
                        <th>添加人员</th>
                        <th>修改人员</th>
                        <th>添加时间</th>
                        <th>修改时间</th>
                        <th>操作</th>
                    </tr>
        		</thead>
                <tbody>
                <?php $num = 0;foreach ($this->getVar('labels') as $key => $value) { $num++;?>
                    <tr>
                        <td><?php echo $num; ?></td>
                        <td><?php echo $value->name; ?></td>
                        <td><?php echo $value->description; ?></td>
                        <td>
                        <?php if ($value->type==1) {?>单行文本<?php } ?>
                        <?php if ($value->type==7) {?>多行文本<?php } ?>
                        <?php if ($value->type==2) {?>时间<?php } ?>
                        <?php if ($value->type==3) {?>图片<?php } ?>
                        <?php if ($value->type==4) {?>附件<?php } ?>
                        <?php if ($value->type==5) {?>编辑器<?php } ?>
                        <?php if ($value->type==6) {?>开关<?php } ?>
                        </td>
                        <td><?php echo $value->create_user; ?></td>
                        <td><?php echo $value->update_user; ?></td>
                        <td><?php echo $value->create_time; ?></td>
                        <td><?php echo $value->update_time; ?></td>
                        <td>
                            <?php echo get_btn_del($value->id);?>
                            <?php echo get_btn_mod($value->id);?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
	  	</div>
	  	
	  	<div class="layui-tab-item">
	  		 <form action="<?php echo \core\basic\Url::get('/admin/Label/add');?>" method="post" class="layui-form">
	  		 	<input type="hidden" name="formcheck" value="<?php echo $this->getVar('formcheck');?>" > 
	  		 	<div class="layui-form-item">
                     <label class="layui-form-label">标签名称</label>
                     <div class="layui-input-block">
                     	<input type="text" name="name" required  lay-verify="required" placeholder="请输入标签名称"  class="layui-input">
                     	<div class="layui-form-mid layui-word-aux">只能含有字母、数字、下划线</div>
                     </div>
                     
                </div>
                
                <div class="layui-form-item">
                     <label class="layui-form-label">标签描述</label>
                     <div class="layui-input-block">
                     	<input type="text" name="description" required  lay-verify="required" placeholder="请输入标签描述"  class="layui-input">
                     </div>
                </div>
                
                <div class="layui-form-item">
                     <label class="layui-form-label">标签类型</label>
                     <div class="layui-input-block">
                     	<select name="type" lay-verify="required">
	                    	<option value="1">单行文本</option>
	                    	<option value="7">多行文本</option>
	                    	<option value="2">时间</option>
	                    	<option value="3">图片</option>
	                    	<option value="4">附件</option>
	                    	<option value="5">编辑器</option>
	                    	<option value="6">开关</option>
	                    </select>
                     </div>
                </div>
                
                <div class="layui-form-item">
					 <div class="layui-input-block">
					    <button class="layui-btn" lay-submit>立即提交</button>
					    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
					 </div>
				</div>
	  		 </form>
	  	</div>
	  	
	  </div>
	</div>
	<?php } ?> 
	
	
	<?php if ($this->getVar('mod')) {?>
	
	<div class="layui-tab layui-tab-brief" lay-filter="tab">
	  <ul class="layui-tab-title">
	    <li class="layui-this">标签修改</li>
	  </ul>
	  <div class="layui-tab-content">
	  	<div class="layui-tab-item layui-show">
	  		  <form action="<?php echo \core\basic\Url::get('/admin/Label/mod/id/'.get('id').'');?><?php echo $this->getVar('backurl');?>" method="post" class="layui-form">
	  		  	<input type="hidden" name="formcheck" value="<?php echo $this->getVar('formcheck');?>" > 
	  		  	<div class="layui-form-item">
                     <label class="layui-form-label">标签名称</label>
                     <div class="layui-input-block">
                     	<input type="text" name="name" required  lay-verify="required" value="<?php echo @$this->getVar('label')->name;?>"  placeholder="请输入标签名称"  class="layui-input">
                     	<div class="layui-form-mid layui-word-aux">只能含有字母、数字、下划线</div>
                     </div>
                     
                </div>
                
                <div class="layui-form-item">
                     <label class="layui-form-label">标签描述</label>
                     <div class="layui-input-block">
                     	<input type="text" name="description" required  lay-verify="required"  value="<?php echo @$this->getVar('label')->description;?>" placeholder="请输入标签描述"  class="layui-input">
                     </div>
                </div>
                
                <div class="layui-form-item">
                     <label class="layui-form-label">标签类型</label>
                     <div class="layui-input-block">
                     	<select name="type" lay-verify="required">
	                    	<option value="1" <?php if ($this->getVar('label')->type==1) {?>selected<?php } ?>>单行文本</option>
	                    	<option value="7" <?php if ($this->getVar('label')->type==7) {?>selected<?php } ?>>多行文本</option>
	                    	<option value="2" <?php if ($this->getVar('label')->type==2) {?>selected<?php } ?>>时间</option>
	                    	<option value="3" <?php if ($this->getVar('label')->type==3) {?>selected<?php } ?>>图片</option>
	                    	<option value="4" <?php if ($this->getVar('label')->type==4) {?>selected<?php } ?>>附件</option>
	                    	<option value="5" <?php if ($this->getVar('label')->type==5) {?>selected<?php } ?>>编辑器</option>
	                    	<option value="6" <?php if ($this->getVar('label')->type==6) {?>selected<?php } ?>>开关</option>
	                    </select>
                     </div>
                </div>
                
                <div class="layui-form-item">
					 <div class="layui-input-block">
					    <button class="layui-btn" lay-submit>立即提交</button>
					    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
					    <?php echo get_btn_back();?>
					 </div>
				</div>
	  		  </form>
	  	</div>
	  </div>
	 </div>
	<?php } ?>

</div>

<!-- 引入编辑器文件 -->
<script type="text/javascript" charset="utf-8" src="<?php echo CORE_DIR;?>/extend/ueditor/ueditor.config.js?v=v2.0.1"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo CORE_DIR;?>/extend/ueditor/ueditor.all.min.js?v=v2.0.1"> </script>
<script type="text/javascript" charset="utf-8" src="<?php echo CORE_DIR;?>/extend/ueditor/lang/zh-cn/zh-cn.js?v=1.3.5"></script>
<script>
//初始化编辑器
$(document).ready(function (e) {
	var ue = UE.getEditor('editor',{
		maximumWords:30000 
	});
})
</script>


<script type="text/javascript">
   <!-- 解决源码模式无法保存 -->
  function editor_init() {
      $('#edit').submit(function () {
          editor=UE.getEditor('editor');
          if(editor.queryCommandState('source')==1) editor.execCommand('source');
      })
  }
 
  <!-- 点击后添加到编辑器 -->
  $(".addedit").on("click",'img',function(){
	    editor=UE.getEditor('editor');
		$img = $(this).attr("src");
		editor.execCommand('inserthtml',"<img src='"+$img+"'>");
   });

</script>

<script type="text/javascript">editor_init();</script>




  <div class="layui-footer">
    <!-- 底部固定区域 -->
    &copy; <a href="http://www.pbootcms.com" target="_blank">2018-2019 PbootCMS版权所有.</a>
  	<span class="layui-hide-xs">{pboot:runtime}</span>
  </div>
</div>

<script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/layui/layui.all.js?v=v2.5.4"></script>
<script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/js/comm.js?v=v2.0.0"></script>
<script type="text/javascript" src="<?php echo APP_THEME_DIR;?>/js/mylayui.js?v=v2.0.6"></script>


<!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
<!--[if lt IE 9]>
  <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
  <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</body>
</html>

<?php return array (
  0 => '/Applications/MAMP/htdocs/apps/admin/view/default/common/head.html',
  1 => '/Applications/MAMP/htdocs/apps/admin/view/default/common/ueditor.html',
  2 => '/Applications/MAMP/htdocs/apps/admin/view/default/common/foot.html',
); ?>