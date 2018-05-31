<?php $identity = Yii::$app->user->getIdentity();?>
<div class="row">
        <div class="col-md-5">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              

                <h3 class="profile-username text-center"><?= $identity->name?></h3>

              <p class="text-muted text-center"><?= $identity->position?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>身份证号</b> <a class="pull-right"><?= $identity->identity_card?></a>
                </li>
                <li class="list-group-item">
                  <b>员工编号</b> <a class="pull-right"><?= $identity->employee_number?></a>
                </li>
                <li class="list-group-item">
                  <b>单位</b> <a class="pull-right"><?= $data->unit->unit_name?></a>
                </li>
                <li class="list-group-item">
                  <b>部门</b> <a class="pull-right"><?= $data->department->dep_name?></a>
                </li>

                <li class="list-group-item">
                  <b>政治面貌</b> <a class="pull-right"><?= $identity->politics_status?></a>
                </li>
                <li class="list-group-item">
                  <b>手机号</b> <a class="pull-right"><?= $identity->mobile?></a>
                </li>
                <li class="list-group-item">
                  <b>邮箱</b> <a class="pull-right"><?= $identity->email?></a>
                </li>
                <li class="list-group-item">
                    <b>上次登录时间</b> <a class="pull-right"><?= isset($employeeLog->login_time) ? $employeeLog->login_time : "无"?></a>
                </li>
                <li class="list-group-item">
                  <b>上次登录IP</b> <a class="pull-right"><?= isset($employeeLog->ip) ? $employeeLog->ip : "无"?></a>
                </li>
<!--                <li class="list-group-item">
                  <b>上次登录转发IP</b> <a class="pull-right"></a>
                </li>-->
                <li class="list-group-item">
                  <b>上次退出登陆时间</b> <a class="pull-right"><?= isset($employeeLog->logout_time) ? $employeeLog->logout_time : "无"?></a>
                </li>
              </ul>

             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

       
        </div>

</div>
