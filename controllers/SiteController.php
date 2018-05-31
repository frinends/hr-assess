<?php
namespace app\controllers;

use app\models\ContactForm;
use app\models\LoginForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use app\models\EmployeeLog;


/**
 * Site controller
 */
class SiteController extends Controller//\app\commands\HelloController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            if(in_array(Yii::$app->user->getIdentity()->role, ["employee"])) 
                return $this->redirect(Yii::$app->urlManager->createUrl("dashboard"));
            else
                return $this->redirect(Yii::$app->urlManager->createUrl("employees"));
            
        }
       
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                    $forwarded_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $forwarded_ip = $_SERVER['HTTP_CLIENT_IP'];
            }else if(!empty($_SERVER['REMOTE_ADDR'])){
                $forwarded_ip = $_SERVER['REMOTE_ADDR'];
            } else {
                    $forwarded_ip = '';
            }
            
            $employeeLog = new EmployeeLog();
            $employeeLog->employee_id = Yii::$app->user->getIdentity()->employee_id;
            $employeeLog->login_time = date("Y-m-d H:i:s");
            $employeeLog->ip = Yii::$app->request->getUserIP();
            $employeeLog->forwarded_ip = $forwarded_ip;
            $employeeLog->save();
            
            if(in_array(Yii::$app->user->getIdentity()->role, ["employee"])) 
                return $this->redirect(Yii::$app->urlManager->createUrl("dashboard"));
            else
                return $this->redirect(Yii::$app->urlManager->createUrl("employees"));
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
     
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    
    /**
     * 403
     */
    public function actionNopermission(){
        return $this->render('error');
    }
    
    
    /**
     * 忘记密码
     */
    public function actionForget(){
        $this->layout = 'main-login';
        if(\Yii::$app->request->isPost){
            $request = Yii::$app->request;
       
            $errors = [];
            $employee_number = $request->post("employee_number");
            $identity_card = $request->post("identity_card");
            $email = $request->post("email");
            $mobile = $request->post("mobile");
            
            if(!isset($employee_number) || empty($employee_number)){
                $errors["employee_number"] = [
                    "err_msg" => "请填写员工编号。"
                ];
            }
            
            if(!isset($identity_card) || empty($identity_card)){
                $errors["identity_card"] = [
                    "err_msg" => "请填写身份证号。"
                ];
            }
            
            if(!isset($email) || empty($email)){
                $errors["email"] = [
                    "err_msg" => "请填写邮箱，如果没有邮箱请联系管理员。"
                ];
            }
//             if(!isset($mobile) || empty($mobile)){
//                $errors["mobile"] = [
//                    "err_msg" => "请填写手机号。"
//                ];
//            }
            
            if(!empty($errors)){
                exit(json_encode(["code"=> -1, "data" => ["errors" => $errors]]));
            }
            $where = [
                "employee_number" => $employee_number,
                "identity_card" => $identity_card,
                "email" => $email,
                //"mobile" => $mobile,
            ];
			
            $employee = \app\models\Employee::find()->where($where)->one();
            
            if(empty($employee)){
                $errors["error_msg"] = [
                    "err_msg" => "信息有误，请仔细核对填写的信息。"
                ];
                exit(json_encode(["code"=> -1, "data" => ["errors" => $errors]]));
            }
            
            if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                    $forwarded_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $forwarded_ip = $_SERVER['HTTP_CLIENT_IP'];
            } else if(!empty($_SERVER['REMOTE_ADDR'])){
                    $forwarded_ip = $_SERVER['REMOTE_ADDR'];
            } else {
                    $forwarded_ip = '';
            }
            
            $model = new \app\models\EmployeeResetpwd();
            $token = md5(bin2hex(uniqid(rand(), true)));
            $model->employee_id = $employee->employee_id;
            $model->token = $token ;
            $model->creat_time = date("Y-m-d H:i:s");
            $model->ip = $forwarded_ip;
            $model->status = '1';
            
            $mail= Yii::$app->mailer->compose();
 
//            $mail->setTo('422765665@qq.com');  
            $mail->setTo($email);  
            $mail->setSubject("忘记密码"); 
            $link = \Yii::$app->request->hostInfo;
            $link .= \Yii::$app->urlManager->createUrl(["site/resetpwd", "token"=>$token]);
            
            $str = '<html><head>
                            <META http-equiv=Content-Type content="text/html; charset=UTF-8">
                            <META content="MSHTML 6.00.2900.2180" name=GENERATOR>
                                <title>重置密码</title>
                            </head>
                            <body>
                            <p>'.$employee->name.'：</p>
                            <p>您的密码重设要求已经得到验证。请点击以下链接输入你新的密码：</p>
                            <p><a href="'.$link.'">'.$link.'</a></p>
                            <p>此链接将在24小时内失效，请尽快修改密码。如果你的email程序不支持链接点击，请将上面的地址拷贝至你的浏览器(例如IE)的地址栏。</p>
                            <p>如果不是本人操作请忽略该邮件。</p>
                            </body>
                            </html>';
            $mail->setHtmlBody($str);    //发布可以带html标签的文本
            if($mail->send() && $model->save()){
                exit(json_encode(["code"=> 0, "data" => ["msg" => "重置密码申请成功，请注意查收邮件。", "href" => Yii::$app->urlManager->createUrl(["site/pwdmessage"])]])); 
            }else{  
                exit(json_encode(["code"=> 0, "data" => ["msg" => "失败", "reload" => 1]])); 
            }
           
        }
        return $this->render('forget_pwd');
    }
    
    
    public function actionPwdmessage(){
        $this->layout = 'main-login';
        return $this->render('forget_msg',["msg" => "重置密码申请成功，请注意查收邮件。"]);
    }

    public function actionResetpwd(){
        $this->layout = 'main-login';
        $token = \Yii::$app->request->get("token");
        $info = \app\models\EmployeeResetpwd::find()->where(["token" => $token])->one();
        if(!$info){
           return $this->render('forget_msg', ["msg" => "非法访问！"]);
        }
        if(\Yii::$app->request->isPost){
            $request = Yii::$app->request;
//            exit(json_encode(["code"=> 0, "data" => ["msg" => "设置成功，请重新登录！", "href" => Yii::$app->urlManager->hostInfo]])); 
            $errors = [];
            $password = $request->post("password");
            $confirm_password = $request->post("confirm_password");

            if(!isset($password) || empty($password) || strlen($password) < 6)
                $errors["password"] = ["err_msg" => "请填写新密码，密码长度不能少于6位。"];
            
            if(!isset($confirm_password) || empty($confirm_password))
                $errors["confirm_password"] = ["err_msg" => "请填写确认新密码。"];
            
            if(!empty($errors))
                exit(json_encode(["code"=> -1, "data" => ["errors" => $errors]]));
            
            if($password == "123456"){
                $errors["password"] = [
                    "err_msg" => "密码过于简单，请重新设置"
                ];
            }
            
            if($password != $confirm_password){
                $errors["confirm_password"] = ["err_msg" => "两次输入的密码不一致。"];
                exit(json_encode(["code"=> -1, "data" => ["errors" => $errors]]));
            }
            
            \app\models\Employee::updateAll(["password"=>md5(md5($password))], "employee_id=".$info->employee_id);
            
            \app\models\EmployeeResetpwd::deleteAll("employee_id=".$info->employee_id);
            
            exit(json_encode(["code"=> 0, "data" => ["msg" => "设置成功，请重新登录！", "href" => Yii::$app->urlManager->hostInfo]])); 
            
        }
       
        if( (time() - strtotime($info->creat_time)) > 24*3600){
            return $this->render('forget_msg', ["msg" => "非法访问！"]);
        } 
        
        $model = new LoginForm();
        return $this->render('reset_pwd',["msg" => "非法访问！", "model"=>$model]);
    }
}
