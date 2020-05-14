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
	<div class="layui-tab layui-tab-brief" lay-filter="tab">
	  <ul class="layui-tab-title">
	    <li class="layui-this" lay-id="t1">在线更新</li>
	    <li lay-id="t2">更新设置</li>
	  </ul>
	  <div class="layui-tab-content">
	  	   <div class="layui-tab-item layui-show">
		  	   	<table class="layui-table">
	            	<thead>
	                    <tr>
	                        <th width="30">选择</th>
	                        <th>更新文件</th>
	                        <th>更新方式</th>
	                        <th>本地时间</th>
	                        <th>更新时间</th>
	                    </tr>
	                </thead>
	                <tbody id="upfile">
	                    <?php $num = 0;foreach ($this->getVar('upfile') as $key => $value) { $num++;?>
	                    <tr>
	                        <td><input type="checkbox" checked class="checkbox checkitem" lay-ignore name="list" value="<?php echo $value->path; ?>"></td>
	                        <td><?php echo $value->path; ?></td>
	                        <td><?php echo $value->type; ?></td>
	                        <td><?php echo $value->ltime; ?></td>
	                        <td><?php echo $value->ctime; ?></td>
	                    </tr>
	                    <?php } ?>
	                    <?php if ($this->getVar('upfile') && get('action')=='local') {?>
	                     <tr>
	                    	 <td><input type="checkbox" class="checkbox" checked lay-ignore id="checkall" title="全选"></td>
	                    	 <td colspan="4">已下载更新：<?php echo $num; ?>个文件</td>
	                    </tr>
	                    <?php } ?>
	                </tbody> 
	            </table>

	             <?php if (get('action')=='local') {?>
	             	<button class="layui-btn" id="check" data-url='<?php echo \core\basic\Url::get('/admin/Upgrade/check');?>'>重新检查</button>
	             <?php } else { ?>
	             	<button class="layui-btn" id="check" data-url='<?php echo \core\basic\Url::get('/admin/Upgrade/check');?>' id="check">检查更新</button>
	             <?php } ?>
	             <button class="layui-btn" <?php if (!$this->getVar('upfile')) {?>style="display:none"<?php } ?> id="update" data-url='<?php echo \core\basic\Url::get('/admin/Upgrade/update');?>'>执行更新</button>
	             <button class="layui-btn" style="display:none" id="down" data-url='<?php echo \core\basic\Url::get('/admin/Upgrade/down');?>'>下载更新</button>
	  	   </div>
	  	   
	  	   <div class="layui-tab-item">
	  	   	   <form action="<?php echo \core\basic\Url::get('/admin/Config/index');?>" method="post" class="layui-form">
	  	   	   	   <input type="hidden" name="formcheck" value="<?php echo $this->getVar('formcheck');?>" > 
	  	   	   	   
	  	   	   	   <div class="layui-form-item">
	                     <label class="layui-form-label">更新分支</label>
	                     <div class="layui-input-inline">
	                     	 <select name="upgrade_branch">
				             	<option value="2.X" <?php if ($this->getVar('branch')=='2.X') {?>selected<?php } ?>>2.X 稳定版</option>
				             	<option value="2.X.dev" <?php if ($this->getVar('branch')=='2.X.dev') {?>selected<?php } ?> >2.X 测试版</option>
				             </select>
	                     </div>
	                </div>
	                
	                <div class="layui-form-item">
	                     <label class="layui-form-label">强制文件同步</label>
	                     <div class="layui-input-block">
	                        <input type="hidden" name="upgrade_force" value="0"><!-- 默认0 -->
	                     	<input type="checkbox" name="upgrade_force" value="1" <?php if ($this->getVar('force')) {?>checked<?php } ?> lay-skin="switch" lay-text="开启|关闭">
	                     </div>
	                    <div class="layui-form-mid layui-word-aux">适用有部分文件更新失败或检查文件与官方一致性。</div>
	                </div>
	                
		            <div class="layui-form-item">
						 <div class="layui-input-block">
						    <button class="layui-btn" lay-submit name="submit" value="upgrade">保存</button>
						    <button type="reset" class="layui-btn layui-btn-primary">重选</button>
						 </div>
					</div>
	           </form>
	  	   </div>
	  </div>
	</div>	
</div>

 <script>
 
//页面加载时检查更新
$.ajax({
    type: 'GET',
	url: 'https://www.pbootcms.com/index.php?p=upgrade/check&version=<?php echo APP_VERSION;?>.<?php echo RELEASE_TIME;?>.<?php echo $this->getVar('revise');?>&branch=<?php echo $this->getVar('branch');?>&snuser=<?php echo $this->getVar('snuser');?>&site=<?php echo $this->getVar('site');?>',
	dataType: 'json',
	success: function (response, status) {
		 if(response.code==1){
			 $("#check").html($("#check").html()+'<span class="layui-badge-dot"></span>');
		 }
    }
 });
 
//检查更新	  	         
$("#check").on("click",check);

//下载更新
$("#update").on("click",update);
  	
//下载更新
$("#down").on("click",down);


//检查更新
function check(){
  	var lyindex;
  	layui.use('layer', function(){
		var layer = layui.layer;
		lyindex = layer.open({
			type: 1,
			title:'检查更新',
			closeBtn:0,
			content: '<div style="padding:20px 10px;"><img src="<?php echo APP_THEME_DIR;?>/layui/css/modules/layer/default/loading-0.gif">正在检查更新文件，请稍等...<div>' 
		});
	});
  		
	var url= $('#check').data('url');
	$.ajax({
   	  type: 'GET',
   	  url: url,
   	  dataType: 'json',
   	  success: function (response, status) {
   		  if(response.code==1){
   			  var data=response.data;
   			  if(!(data instanceof Array)){
   				  layer.close(lyindex);
      		  	  layer.msg(data, {icon: 1});
   			  }else{
	     		   var html='';
	      		   for(var i = 0; i < data.length; i++){
	       	        	html += '<tr><td><input type="checkbox" checked class="checkbox checkitem" lay-ignore name="list" value="'+data[i].path+'"></td><td>'+data[i].path+'</td><td>'+data[i].type+'</td><td>'+data[i].ltime+'</td><td>'+data[i].ctime+'</td></tr>';
	       	   	   }
	      		   html += '<tr><td><input type="checkbox" class="checkbox" checked lay-ignore id="checkall" title="全选"></td><td colspan="4">总共检测到 '+i+' 个文件</td></tr>';
	      		   $("#upfile").html('');
	      		   $("#upfile").append(html);
	      		   layer.close(lyindex);
	      		   layer.msg('共检测到 '+i+' 个文件需要更新！', {icon: 1});
	      		   $('#update').hide();
	      		   $('#down').show();
   			  }
     		  $('#check').text('重新检查');
   		  }else{
   			 layer.close(lyindex);
   			 layer.msg(response.data, {icon: 5});
   		  }
   		   
        },
        error:function(xhr,status,error){
     	  layer.close(lyindex);
       	  layer.msg("检查更新发生错误!", {icon: 5});
        }
   	});
}

//下载更新
function down(){
	var lyindex;
  	    var layer;
  	    layui.use('layer', function(){
		  	layer = layui.layer;
		  	lyindex = layer.open({
			type: 1,
			title:'下载更新',
			closeBtn:0,
			content: '<div style="padding:20px 10px;"><img src="<?php echo APP_THEME_DIR;?>/layui/css/modules/layer/default/loading-0.gif"><span id="layer-content">正在下载更新文件，请稍等...</span><div>'
		});
	});

	var url= $('#down').data('url');
	var checked = $(".checkitem:checked");
	var len = $(checked).length;
	var exe=0;
	$(checked).each(function(index,element){
		 setTimeout(function () { //延迟执行、避免文件太多卡死问题
			 $.ajax({
		    	  type: 'GET',
		    	  url: url,
		    	  dataType: 'json',
		    	  async:true,
		    	  data: {
		    		  list:$(element).val()
		    	  },
		    	  success: function (response, status) {
		    		 if(response.code==1){
		    			 exe++;
		    			 $('#layer-content').text(response.data);
		    		 }else{
		    			 layer.close(lyindex);
		     			 layer.msg(response.data, {icon: 5}); 
		    		 }
		    		 
		    		 if(exe==len){
			  			layer.close(lyindex);
			  	   	 	layer.open({
			  			  type: 0,
			  			  title:'下载更新',
			  			  closeBtn:0,
			  			  btn: ['立即更新', '稍后更新'],
			  			  content: '所选文件全部下载完成!',
			  			  yes: function(index, layero){
			  				  layer.close(index); 
			  				  $('#update').click();
			  				  
			  			   },
			  			  btn2: function(index, layero){
			  				 layer.close(index); 
			  				 window.location.href = '<?php echo \core\basic\Url::get('/admin/Upgrade/index/action/local');?>';
			  			   }
			  			});
			  	   	 	$('#update').show();
			  			$('#down').hide();
			  		 } 
		         },
		         error:function(xhr,status,error){
		       	      layer.close(lyindex);
		        	  layer.msg("下载更新文件发生错误!", {icon: 5});
		         }
		   	});
		}, index*1000);
    });
}
   	
//执行更新
function update(){
	var lyindex;
  	    var layer;
  	    layui.use('layer', function(){
	  	layer = layui.layer;
	  	lyindex = layer.open({
		  type: 1,
		  title:'执行更新',
		  closeBtn:0,
		  content: '<div style="padding:20px 10px;"><img src="<?php echo APP_THEME_DIR;?>/layui/css/modules/layer/default/loading-0.gif"><span id="layer-content">正在执行更新文件，请稍等...</span><div>'
		});
	});

    //由于涉及到数据库升级文件先后顺序，所以必须一次性提交	
	var url= $('#update').data('url');
	var list='';
	$(".checkitem:checked").each(function(index,element){
		if(index==0){
			list += $(element).val();
		}else{
			list += ','+$(element).val();
		}
	});
	
 	$.ajax({
  	  type: 'POST',
  	  url: url,
  	  dataType: 'json',
  	  data: {
  		  list:list
  	  },
  	  success: function (response, status) {
  		 if(response.code==1){
  			layer.close(lyindex);
  			layer.open({
 				  type: 0,
 				  title:'执行更新',
 				  closeBtn:0,
 				  content: '所选文件全部更新完成!',
 				  yes: function(index, layero){
 					  window.location.href = '<?php echo \core\basic\Url::get('/admin/Upgrade/index');?>';
 					  layer.close(index); 
 				   }
 				});
  		 }else{
  			 layer.close(lyindex);
   			 layer.msg(response.data, {icon: 5}); 
  		 }
       },
       error:function(xhr,status,error){
      	  layer.msg("执行更新文件发生错误!", {icon: 5});
       }
 	});
}
   	
//选择全部
$("#upfile").on("click","#checkall", function () {
	if($(this).prop("checked")){
		$(".checkitem:enabled").prop("checked", true);
	}else{
		$(".checkitem").prop("checked", false);
	} 
});  
   	 	  
</script>

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