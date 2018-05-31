
<?php

$id = Yii::$app->controller->id;
$actionId = Yii::$app->controller->action->id;
if(Yii::$app->user->isGuest){
    return $this->goHome();
}

$role = Yii::$app->user->getIdentity()->role;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel" style="padding-bottom: 40px;">
            <div class="pull-left image">
<!--                <img src="/img/logo_a.png" alt=""/>-->
            </div>
            <div class=" info">
                <p><?= Yii::$app->user->getIdentity()->name?></p>
            </div>
        </div>

        <ul class="sidebar-menu">
            
            <?php if($role == "employee"):?>
            <li class="<?= $id == "dashboard"  ? "active" : ""?>">
                <a href="<?= Yii::$app->urlManager->createUrl("dashboard")?>">
                    <i class="fa fa-dashboard"></i>  <span>个人信息</span>
                </a>
            </li>
            
            <li class="<?= $id == "ptask" ? "active" : ""?>">
                <a href="<?= Yii::$app->urlManager->createUrl("ptask")?>">
                    <i class="fa fa-tasks"></i>  <span>绩效考核</span>
                </a>
            </li>
            
            <li class="<?= $id == "staffsummary"  ? "active" : ""?>">
                <a href="<?= Yii::$app->urlManager->createUrl("staffsummary")?>">
                    <i class="fa fa-tasks"></i>  <span>工作总结</span>
                </a>
            </li>
            
            <li class="<?= $id == "wage"  ? "active" : ""?>">
                <a href="<?= Yii::$app->urlManager->createUrl("wage")?>">
                    <i class="fa fa-cny"></i>  <span>薪资查询</span>
                </a>
            </li>
            
            <?php endif;?>
            
            <?php if($role == "admin"):?>
            <!-- admin 员工管理 -->
            <li class="<?= $id == "employees" && $actionId!="changepwd" ? "active" : ""?>">
                <a href="javascript:;">
                    <i class="fa fa-user"></i>  <span>员工管理</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu" >
                    <li class="<?= in_array($actionId, ["index", "info"]) ? "active" : ""?>">
                        <a href="<?= Yii::$app->urlManager->createUrl("employees")?>">
                            <i class="fa fa-circle-o"></i><span>所有员工</span>
                        </a>
                        
                    </li>
                    <li class="<?= in_array($actionId, ["add"]) ? "active" : ""?>">
                        <a href="<?= Yii::$app->urlManager->createUrl("employees/add")?>">
                            <i class="fa fa-circle-o"></i><span>新增员工</span>
                        </a>
                    </li>
                    
                </ul>
            </li>
            <!-- admin 公司管理 -->
            <li class="<?= $id == "company" ? "active" : ""?>">
                <a href="javascript:;">
                    <i class="fa fa-dashboard"></i>
                    <span>公司管理</span> 
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu" >
                    <li class="<?= in_array($actionId, ["unit", "unit_detail"]) ? "active" : ""?>">
                        <a href="<?= Yii::$app->urlManager->createUrl("company/unit")?>">
                            <i class="fa fa-circle-o"></i><span>单位管理</span>
                        </a>
                    </li>
                    <li class="<?= in_array($actionId, ["department", "department_detail"]) ? "active" : ""?>">
                        <a href="<?= Yii::$app->urlManager->createUrl("company/department")?>">
                            <i class="fa fa-circle-o"></i><span>部门管理</span>
                        </a>
                    </li>
                    <li class="<?= in_array($actionId, ["rank", "rank_detail"]) ? "active" : ""?>">
                         <a href="<?= Yii::$app->urlManager->createUrl("company/rank")?>">
                            <i class="fa fa-circle-o"></i><span>职级管理</span>
                        </a>
                    </li>
                    <li class="<?= in_array($actionId, [ "in_charge"]) ? "active" : ""?>">
                         <a href="<?= Yii::$app->urlManager->createUrl("company/in_charge")?>">
                            <i class="fa fa-circle-o"></i><span>分管关系</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- admin 绩效考核 -->
            <li class="<?= $id == "performance" ? "active" : ""?>">
                <a href="javascript:;">
                    <i class="fa fa-tasks"></i>
                    <span>绩效考核管理</span> 
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu" >
                    <li class="<?= in_array($actionId, ["task", "task_info"]) ? "active" : ""?>">
                        <a href="<?= Yii::$app->urlManager->createUrl("performance/task")?>">
                            <i class="fa fa-circle-o"></i><span>绩效考核任务</span>
                        </a>
                    </li>
                    <li class="<?= in_array($actionId, ["tpl", "tplinfo"]) ? "active" : ""?>">
                        <a href="<?= Yii::$app->urlManager->createUrl(["performance/tpl"])?>">
                            <i class="fa fa-circle-o"></i><span>考核模版</span>
                        </a>
                    </li>
                    <li class="<?= in_array($actionId, ["tpladd"]) ? "active" : ""?>">
                        <a href="<?= Yii::$app->urlManager->createUrl(["performance/tpladd"])?>">
                            <i class="fa fa-circle-o"></i><span>添加考核模版</span>
                        </a>
                    </li>
                    <li class="<?= in_array($actionId, ["pub", "settaskoption"]) ? "active" : ""?>">
                        <a href="<?= Yii::$app->urlManager->createUrl(["performance/pub"])?>">
                            <i class="fa fa-circle-o"></i><span>发布考核任务</span>
                        </a>
                    </li>
                    <li class="<?= in_array($actionId, ["other", "setother"]) ? "active" : ""?>">
                        <a href="<?= Yii::$app->urlManager->createUrl(["performance/other"])?>">
                            <i class="fa fa-circle-o"></i><span>不考核名单</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- admin 工作总结 -->
            <li class="<?= $id == "worksummary" ? "active" : ""?>">
                <a href="javascript:;">
                    <i class="fa fa-tasks"></i>
                    <span>工作总结管理</span> 
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu" >
                    <li class="<?= in_array($actionId, ["index", "info"]) ? "active" : ""?>">
                        <a href="<?= Yii::$app->urlManager->createUrl("worksummary")?>">
                            <i class="fa fa-circle-o"></i><span>工作总结</span>
                        </a>
                    </li>
                    <li class="<?= in_array($actionId, [ "add"]) ? "active" : ""?>">
                        <a href="<?= Yii::$app->urlManager->createUrl("worksummary/add")?>">
                            <i class="fa fa-circle-o"></i><span>发布工作总结任务</span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php endif;?>
            
            <?php if(in_array($role, ["salary", "admin"])):?>
            <li class="<?= $id == "salary" ? "active" : ""?>">
                <a href="javascript:;"><i class="fa fa-cny"></i>  <span>薪资管理</span>
                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu" >
                    <li class="<?= in_array($actionId, ["index"]) ? "active" : ""?>">
                        <a href="<?= Yii::$app->urlManager->createUrl("salary")?>">
                            <i class="fa fa-circle-o"></i><span>薪资查询</span>
                        </a>
                    </li>
                    <li class="<?= in_array($actionId, ["model"]) ? "active" : ""?>">
                        <a href="<?= Yii::$app->urlManager->createUrl("salary/model")?>">
                            <i class="fa fa-circle-o"></i><span>设置薪资模版</span>
                        </a>
                    </li>
                    <li class="<?= in_array($actionId, ["add"]) ? "active" : ""?>">
                        <a href="<?= Yii::$app->urlManager->createUrl("salary/add")?>">
                            <i class="fa fa-circle-o"></i><span>上传薪资</span>
                        </a>
                    </li>
                    
                </ul>
            </li>
            <?php endif;?>
            
            <li class="<?= $actionId == "changepwd" ? "active" : ""?>">
                <a href="<?= Yii::$app->urlManager->createUrl("employees/changepwd")?>"><i class="fa fa-lock"></i>  <span>修改密码</span></a>
            </li>
            
            <li >
                <a href="<?= Yii::$app->urlManager->createUrl("employees/logout")?>"><i class="fa fa-book"></i>  <span>退出登录</span></a>
            </li>
            
            
        </ul>
    </section>

</aside>
