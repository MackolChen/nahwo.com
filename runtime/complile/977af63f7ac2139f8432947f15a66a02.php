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
	    <li class="layui-this" lay-id="t1">扩展字段列表</li>
	    <li lay-id="t2">扩展字段新增</li>
	  </ul>
	  <div class="layui-tab-content">
	  	   <div class="layui-tab-item layui-show">
	  	   		<table class="layui-table">
	            	<thead>
	                    <tr>
	                    	<th>序号</th>
	                        <th>内容模型</th>
	                        <th>字段描述</th>
	                        <th>字段名称</th>
	                        <th>字段类型</th>
	                        <th>排序</th>
	                        <th>操作</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $num = 0;foreach ($this->getVar('extfields') as $key => $value) { $num++;?>
	                    <tr>
	                    	<td><?php echo @(PAGE-1)*PAGESIZE+$num; ?></td>
	                    	<td>
	                    		<?php $num2 = 0;foreach ($this->getVar('models') as $key2 => $value2) { $num2++;?>	
	                        		<?php if ($value2->mcode==$value->mcode) {?>
										<?php echo $value2->name; ?>
									<?php } ?>                        	
			                	<?php } ?>
							</td>
	                        <td><?php echo $value->description; ?></td>
	                        <td><?php echo $value->name; ?></td>
	                        <td>
	                        	<?php if ($value->type==1) {?>单行文本<?php } ?>
	                    		<?php if ($value->type==2) {?>多行文本<?php } ?>
	                    		<?php if ($value->type==3) {?>单选按钮<?php } ?>
	                    		<?php if ($value->type==4) {?>多选按钮<?php } ?>
	                    		<?php if ($value->type==5) {?>图片上传<?php } ?>
	                    		<?php if ($value->type==6) {?>附件上传<?php } ?>
	                    		<?php if ($value->type==7) {?>日期选择<?php } ?>
	                    		<?php if ($value->type==8) {?>编辑器<?php } ?>
	                    		<?php if ($value->type==9) {?>下拉选择<?php } ?>
							</td>
							<td><?php echo $value->sorting; ?></td>
	                        <td>
	                            <?php echo get_btn_del($value->id);?>
	                            <?php echo get_btn_mod($value->id);?>
	                        </td>
	                    </tr>
	                    <?php } ?>
	                </tbody>
	            </table>
	            <div class="page"><?php echo $this->getVar('pagebar');?></div>
	  	   </div>
	  	   
	  	    <div class="layui-tab-item">
	   			<form action="<?php echo \core\basic\Url::get('/admin/ExtField/add');?>" method="post" class="layui-form">
	   				<input type="hidden" name="formcheck" value="<?php echo $this->getVar('formcheck');?>" > 
	   				<div class="layui-form-item">
	                     <label class="layui-form-label">内容模型</label>
	                     <div class="layui-input-block">
	                     	 <select name="mcode" lay-verify="required">
		                        <option value="">请选择内容模型</option>
		                        <?php $num = 0;foreach ($this->getVar('models') as $key => $value) { $num++;?>	                        	
		                        	<option value="<?php echo $value->mcode; ?>"><?php echo $value->name; ?></option>
		                        <?php } ?>
		                    </select>
	                     </div>
	                </div>
	                
	                <div class="layui-form-item">
	                     <label class="layui-form-label">字段描述</label>
	                     <div class="layui-input-block">
	                     	<input type="text" name="description" required lay-verify="required"  placeholder="请输入字段描述，如：产品价格" class="layui-input">
	                     </div>
	                </div>
	                
	                <div class="layui-form-item">
	                     <label class="layui-form-label">字段名称</label>
	                     <div class="layui-input-block">
	                     	<input type="text" name="name" required maxlength="20" lay-verify="required"  placeholder="请输入字段名称,字母、数组、下划线，如：price" class="layui-input">
	                     </div>
	                </div>
	                
	                <div class="layui-form-item">
	                     <label class="layui-form-label">字段类型</label>
	                     <div class="layui-input-block">
	                     	 <select name="type" lay-verify="required">
		                    	<option value="1">单行文本</option>
		                    	<option value="2">多行文本</option>
		                    	<option value="3">单选按钮</option>
		                    	<option value="4">多选按钮</option>
		                    	<option value="5">图片上传</option>
		                    	<option value="6">附件上传</option>
		                    	<option value="7">日期选择</option>
		                    	<option value="8">编辑器</option>
		                    	<option value="9">下拉选择</option>
		                    </select>
	                     </div>
	                </div>
	                
	                <div class="layui-form-item">
	                     <label class="layui-form-label">选择按钮值</label>
	                     <div class="layui-input-block">
	                     	<textarea name="value" placeholder="多个选项用逗号隔开或者回车"  class="layui-textarea"></textarea>
	                     	<div class="layui-form-mid layui-word-aux">只在类型为单选或多选时填写有效。</div>
	                     </div>
	                </div>
	                
	                <div class="layui-form-item">
	                     <label class="layui-form-label">排序</label>
	                     <div class="layui-input-block">
	                     	<input type="text" name="sorting" required lay-verify="required" value="255" placeholder="请输入排序"  class="layui-input">
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
	    <li class="layui-this">扩展字段修改</li>
	  </ul>
	  <div class="layui-tab-content">
	  	<div class="layui-tab-item layui-show">
	  		<form action="<?php echo \core\basic\Url::get('/admin/ExtField/mod/id/'.get('id').'');?><?php echo $this->getVar('backurl');?>" method="post" class="layui-form">
	  			<input type="hidden" name="formcheck" value="<?php echo $this->getVar('formcheck');?>" > 
	  			<div class="layui-form-item">
                     <label class="layui-form-label">内容模型</label>
                     <div class="layui-input-block">
                     	 <select name="mcode" lay-verify="required">
	                        <option value="">请选择内容模型</option>
	                        <?php $num = 0;foreach ($this->getVar('models') as $key => $value) { $num++;?>	                        	
	                        	<option value="<?php echo $value->mcode; ?>" <?php if ($value->mcode==$this->getVar('extfield')->mcode) {?>selected<?php } ?>><?php echo $value->name; ?></option>
	                        <?php } ?>
	                    </select>
                     </div>
                </div>
                
                <div class="layui-form-item">
                     <label class="layui-form-label">字段描述</label>
                     <div class="layui-input-block">
                     	<input type="text" name="description"  value="<?php echo @$this->getVar('extfield')->description;?>" placeholder="请输入字段描述，如：产品价格" class="layui-input">
                     </div>
                </div>
                
                <div class="layui-form-item">
                     <label class="layui-form-label">字段名称</label>
                     <div class="layui-input-block">
                     	<input type="text" name="name" readonly value="<?php echo @$this->getVar('extfield')->name;?>" maxlength="20" placeholder="请输入字段名称，字母、数组、下划线，如：price" class="layui-input readonly">
                     </div>
                </div>
                
                <div class="layui-form-item">
                     <label class="layui-form-label">字段类型</label>
                     <div class="layui-input-block">
                     	 <select name="type" lay-verify="required">
	                    	<?php if ($this->getVar('extfield')->type==2) {?>
	                    		<option value="2" selected>多行文本</option>
	                    	<?php } ?>
	                    	
	                    	<?php if ($this->getVar('extfield')->type==7) {?>
	                    		<option value="7" selected>日期选择</option>
	                    	<?php } ?>
	                    	
	                    	<?php if ($this->getVar('extfield')->type==8) {?>
	                    		<option value="8" selected>编辑器</option>
	                    	<?php } ?>
	                    	
	                    	<?php if ($this->getVar('extfield')->type!=2 && $this->getVar('extfield')->type!=7 && $this->getVar('extfield')->type!=8) {?>
	                    		<option value="1" <?php if ($this->getVar('extfield')->type==1) {?>selected<?php } ?>>单行文本</option>
	                    		<option value="3" <?php if ($this->getVar('extfield')->type==3) {?>selected<?php } ?>>单选按钮</option>
	                    		<option value="4" <?php if ($this->getVar('extfield')->type==4) {?>selected<?php } ?>>多选按钮</option>
	                    		<option value="5" <?php if ($this->getVar('extfield')->type==5) {?>selected<?php } ?>>图片上传</option>
	                    		<option value="6" <?php if ($this->getVar('extfield')->type==6) {?>selected<?php } ?>>附件上传</option>
	                    		<option value="9" <?php if ($this->getVar('extfield')->type==9) {?>selected<?php } ?>>下拉选择</option>
	                    	<?php } ?>
	                    </select>
                     </div>
                </div>
                
                <div class="layui-form-item">
                     <label class="layui-form-label">选择按钮值</label>
                     <div class="layui-input-block">
                     	<textarea name="value" placeholder="多个选项用逗号或回车隔开"  class="layui-textarea"><?php echo @$this->getVar('extfield')->value;?></textarea>
                     	<div class="layui-form-mid layui-word-aux">只在类型为单选或多选时填写有效，多个选项用逗号或回车隔开。</div>
                     </div>
                </div>
                
                <div class="layui-form-item">
                     <label class="layui-form-label">排序</label>
                     <div class="layui-input-block">
                     	<input type="text" name="sorting" required lay-verify="required" value="<?php echo @$this->getVar('extfield')->sorting;?>" placeholder="请输入排序"  class="layui-input">
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
  1 => '/Applications/MAMP/htdocs/apps/admin/view/default/common/foot.html',
); ?>