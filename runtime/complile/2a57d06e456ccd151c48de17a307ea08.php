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
	    <li class="layui-this" lay-id="t1">用户列表</li>
	    <li lay-id="t2">用户新增</li>
	  </ul>
	  <div class="layui-tab-content">
	  	   <div class="layui-tab-item layui-show">
	  	   		<form action="<?php echo \core\basic\Url::get('/admin/User/index');?>" method="get" class="layui-form">
		  	   		<div class="layui-form-item nospace">
		  	   			<div class="layui-input-inline">
		  	   			  <?php echo $this->getVar('pathinfo');?>
					       <select name="field" lay-verify="required">
	                            <option value="ucode" <?php if (get('field')=='ucode') {?>selected="selected" <?php } ?> >用户编码</option>
								<option value="username" <?php if (get('field')=='username') {?>selected="selected" <?php } ?>>用户名</option>
	                       </select>
					    </div>
	                     <div class="layui-input-inline">
	                     	<input type="text" name="keyword"  value="<?php echo get('keyword');?>"  placeholder="请输入搜索关键字" class="layui-input">
	                     </div>
	                     <div class="layui-input-inline">
	                     	<button class="layui-btn" lay-submit>搜索</button>
	                     	<a class="layui-btn layui-btn-primary"  href="<?php echo \core\basic\Url::get('/admin/User/index');?>">清除搜索</a>
	                     </div>
	                </div>
                </form>
	                
	  	   		<table class="layui-table">
	  	   			 <tr>
	                    <th>序号</th>
	                    <th>用户编码</th>
	                    <th>用户名</th>
	                    <th>真实名字</th>
	                    <th>状态</th>
	                    <th>用户角色</th>
	                    <th>登录次数</th>
	                    <th>最后登录IP</th>
	                    <th>最后登录时间</th>
	                    <th>操作</th>
	                </tr>
	                
	                <?php $num = 0;foreach ($this->getVar('users') as $key => $value) { $num++;?>
	                <tr>
	                    <td><?php echo @(PAGE-1)*PAGESIZE+$num; ?></td>
	                    <td><?php echo $value->ucode; ?></td>
	                    <td><?php echo $value->username; ?></td>
	                    <td><?php echo $value->realname; ?></td>
	                    <td>
	                    	<?php if ($value->ucode=='10001') {?>
	                    		<i class='fa fa-toggle-on' title="超级管理员不可操作"></i>
	                    	<?php } else { ?>
		                        <?php if ($value->status) {?>
		                        <a href="<?php echo \core\basic\Url::get('/admin/'.C.'/mod/ucode/'.$value->ucode.'/field/status/value/0');?>"><i class='fa fa-toggle-on' title="点击关闭"></i></a>
		                        <?php } else { ?>
		                        <a href="<?php echo \core\basic\Url::get('/admin/'.C.'/mod/ucode/'.$value->ucode.'/field/status/value/1');?>"><i class='fa fa-toggle-off' title="点击开启"></i></a>
		                        <?php } ?>
	                        <?php } ?>
	                    </td>
	                    <td><?php echo $value->rolename; ?></td>
	                    <td><?php echo $value->login_count; ?></td>
	                    <td><?php echo @long2ip($value->last_login_ip);?></td>
	                    <td><?php echo $value->update_time; ?></td>
	                    <td>
	                    	<?php if ($value->ucode=='10001') {?>
	                        	不可操作
	                        <?php } else { ?>
	                        	<?php echo get_btn_del($value->ucode,'ucode');?>
	                        	<?php echo get_btn_mod($value->ucode,'ucode');?>
	                        <?php } ?>
	                        
	                    </td>
	                </tr>
	                <?php } ?>
	  	   		</table>
	  	   		<div class="page"><?php echo $this->getVar('pagebar');?></div>
	  	   	</div>
	  	   	
	  	   	<div class="layui-tab-item">
	  	   		<form action="<?php echo \core\basic\Url::get('/admin/User/add');?>" method="post" class="layui-form">
	  	   			<input type="hidden" name="formcheck" value="<?php echo $this->getVar('formcheck');?>" > 
	  	   			<div class="layui-form-item">
	                     <label class="layui-form-label">用户账号</label>
	                     <div class="layui-input-block">
	                     	<input type="text" name="username" required  lay-verify="required" placeholder="请输入用户账号" class="layui-input">
	                     </div>
	                </div>
	                
	                <div class="layui-form-item">
	                     <label class="layui-form-label">真实姓名</label>
	                     <div class="layui-input-block">
	                     	<input type="text" name="realname"  placeholder="请输入真实姓名" class="layui-input">
	                     </div>
	                </div>
	                
	                <div class="layui-form-item">
	                     <label class="layui-form-label">用户密码</label>
	                     <div class="layui-input-block">
	                     	<input type="password" name="password" required lay-verify="required" placeholder="请输入用户密码" autocomplete="off" class="layui-input">
	                     </div>
	                </div>
	                
	                <div class="layui-form-item">
	                     <label class="layui-form-label">确认密码</label>
	                     <div class="layui-input-block">
	                     	<input type="password" name="rpassword" required lay-verify="required" placeholder="请输入确认密码" autocomplete="off" class="layui-input">
	                     </div>
	                </div>
	                
	                <div class="layui-form-item">
	                     <label class="layui-form-label">账号状态</label>
	                     <div class="layui-input-block">
	                     	<input type="radio" name="status" value="1" title="启用" checked>
							<input type="radio" name="status" value="0" title="禁用">
	                     </div>
	                </div>
	                
	                <div class="layui-form-item">
	                     <label class="layui-form-label">用户角色</label>
	                     <div class="layui-input-block">
	                     	<select name="roles[]">
		                        <?php $num = 0;foreach ($this->getVar('roles') as $key => $value) { $num++;?>
		                            <option value="<?php echo $value->rcode; ?>"><?php echo $value->name; ?></option>
		                        <?php } ?>
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
    
    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
	  <ul class="layui-tab-title">
	    <li class="layui-this">用户修改</li>
	  </ul>
	  <div class="layui-tab-content">
	  	   <div class="layui-tab-item layui-show">
	  	   		 <form action="<?php echo \core\basic\Url::get('/admin/User/mod/ucode/'.get('ucode').'');?><?php echo $this->getVar('backurl');?>" method="post" class="layui-form">
	  	   		 	<input type="hidden" name="formcheck" value="<?php echo $this->getVar('formcheck');?>" > 
	  	   		 	<div class="layui-form-item">
	                     <label class="layui-form-label">用户账号</label>
	                     <div class="layui-input-block">
	                     	<input type="text" name="username" required  lay-verify="required" value="<?php echo @$this->getVar('user')->username;?>" placeholder="请输入用户账号" class="layui-input">
	                     </div>
	                </div>
	                
	                <div class="layui-form-item">
	                     <label class="layui-form-label">真实姓名</label>
	                     <div class="layui-input-block">
	                     	<input type="text" name="realname" value="<?php echo @$this->getVar('user')->realname;?>" placeholder="请输入真实姓名" class="layui-input">
	                     </div>
	                </div>
	                
	                <div class="layui-form-item">
	                     <label class="layui-form-label">用户密码</label>
	                     <div class="layui-input-block">
	                     	<input type="password" name="password"  placeholder="请输入用户密码" autocomplete="off" class="layui-input">
	                     </div>
	                </div>
	                
	                <div class="layui-form-item">
	                     <label class="layui-form-label">确认密码</label>
	                     <div class="layui-input-block">
	                     	<input type="password" name="rpassword"  placeholder="请输入确认密码" autocomplete="off" class="layui-input">
	                     </div>
	                </div>
	                
	                <div class="layui-form-item">
	                     <label class="layui-form-label">账号状态</label>
	                     <div class="layui-input-block">
	                     	<input type="radio" name="status" value="1" title="启用" <?php if ($this->getVar('user')->status==1) {?>checked<?php } ?>>
							<input type="radio" name="status" value="0" title="禁用" <?php if ($this->getVar('user')->status==0) {?>checked<?php } ?>>
	                     </div>
	                </div>
	                
	                <div class="layui-form-item">
	                     <label class="layui-form-label">用户角色</label>
	                     <div class="layui-input-block">
	                     	<select name="roles[]">
		                        <?php $num = 0;foreach ($this->getVar('roles') as $key => $value) { $num++;?>
		                            <option value="<?php echo $value->rcode; ?>" <?php if (in_array($value->rcode,$this->getVar('user')->rcodes)) {?>selected<?php } ?>><?php echo $value->name; ?></option>
		                        <?php } ?>
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