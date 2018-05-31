<?php

namespace app\models;

use Yii;
use app\models\Employee;
use yii\data\Pagination;
/**
 * This is the model class for table "{{%salary}}".
 *
 * @property integer $id
 * @property string $department
 * @property string $employee_number
 * @property integer $year
 * @property integer $month
 * @property string $name
 * @property string $position
 * @property string $company
 * @property string $rangeCode
 * @property string $range
 * @property string $group
 * @property string $subGroup
 * @property string $salary
 * @property string $areaAllowance
 * @property string $salaryTo
 * @property string $pensionToPer
 * @property string $unemploymentToPer
 * @property string $medicareToPer
 * @property string $housingFundToPer
 * @property string $totalNum
 * @property string $perTax
 * @property string $perTaxEnt
 * @property string $medicareOther
 * @property string $takeHomePay
 * @property string $pensionToEnt
 * @property string $injuryInsurance
 * @property string $unemploymentToEnt
 * @property string $birthInsurance
 * @property string $medicareToEnt
 * @property string $housingFundToEnt
 * @property string $medicareOtherEnt
 * @property string $passMedicareOtherEnt
 * @property string $medicareOtherEntTotal
 * @property string $medicareOtherEntTax
 * @property string $retroactivePay
 * @property string $areaSubsidy
 * @property string $plusSalary
 * @property string $warmSubsidy
 * @property string $bonus
 * @property string $vacationAllowance
 * @property string $aidInRemoteAreas
 * @property string $holidayAllowance
 * @property string $coolingAllowance
 * @property string $salaryPreTaxsReissue
 * @property string $salaryPreTaxDeductions
 * @property string $salaryAfterTaxReissue
 * @property string $salaryAfterTaxDeductions
 * @property string $otherPreTaxsReissue
 * @property string $otherAfterTaxReissue
 * @property string $otherPreTaxDeductions
 * @property string $otherAfterTaxDeductions
 * @property string $salaryAdjust
 * @property string $otherDeductions
 * @property string $otherWelPreTaxReissue
 * @property string $otherWelAfterTaxReissue
 * @property string $otherWelPreTaxDeductions
 * @property string $otherWelAfterTaxDeductions
 * @property string $otherAfterTaxSalary
 * @property string $annualPerBonus
 * @property string $yearEndBonus
 * @property string $otherBonus
 * @property string $Allowancelift
 * @property string $OtherPretaxdeduction
 * @property string $Suppinsurancelift
 * @property string $Afterreplacement
 * @property string $otherlacement
 * @property string $otherldeduction
 * @property string $performance
 * @property string $year_work
 */
class Salary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%salary}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year', 'month'], 'integer'],
            [['salary', 'areaAllowance', 'salaryTo', 'pensionToPer', 'unemploymentToPer', 'medicareToPer', 'housingFundToPer', 'totalNum', 'perTax', 'perTaxEnt', 'medicareOther', 'takeHomePay', 'pensionToEnt', 'injuryInsurance', 'unemploymentToEnt', 'birthInsurance', 'medicareToEnt', 'housingFundToEnt', 'medicareOtherEnt', 'passMedicareOtherEnt', 'medicareOtherEntTotal', 'medicareOtherEntTax', 'retroactivePay', 'areaSubsidy', 'plusSalary', 'warmSubsidy', 'bonus', 'vacationAllowance', 'aidInRemoteAreas', 'holidayAllowance', 'coolingAllowance', 'salaryPreTaxsReissue', 'salaryPreTaxDeductions', 'salaryAfterTaxReissue', 'salaryAfterTaxDeductions', 'otherPreTaxsReissue', 'otherAfterTaxReissue', 'otherPreTaxDeductions', 'otherAfterTaxDeductions', 'salaryAdjust', 'otherDeductions', 'otherWelPreTaxReissue', 'otherWelAfterTaxReissue', 'otherWelPreTaxDeductions', 'otherWelAfterTaxDeductions', 'otherAfterTaxSalary', 'annualPerBonus', 'yearEndBonus', 'otherBonus', 'Allowancelift', 'OtherPretaxdeduction', 'Suppinsurancelift', 'Afterreplacement', 'otherlacement', 'otherldeduction', 'performance', 'year_work'], 'number'],
            [['department', 'employee_number'], 'string', 'max' => 30],
            [['name', 'group'], 'string', 'max' => 15],
            [['position', 'range', 'subGroup'], 'string', 'max' => 20],
            [['company'], 'string', 'max' => 25],
            [['rangeCode'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'department' => 'Department',
            'employee_number' => 'Employee Number',
            'year' => 'Year',
            'month' => 'Month',
            'name' => 'Name',
            'position' => 'Position',
            'company' => 'Company',
            'rangeCode' => 'Range Code',
            'range' => 'Range',
            'group' => 'Group',
            'subGroup' => 'Sub Group',
            'salary' => 'Salary',
            'areaAllowance' => 'Area Allowance',
            'salaryTo' => 'Salary To',
            'pensionToPer' => 'Pension To Per',
            'unemploymentToPer' => 'Unemployment To Per',
            'medicareToPer' => 'Medicare To Per',
            'housingFundToPer' => 'Housing Fund To Per',
            'totalNum' => 'Total Num',
            'perTax' => 'Per Tax',
            'perTaxEnt' => 'Per Tax Ent',
            'medicareOther' => 'Medicare Other',
            'takeHomePay' => 'Take Home Pay',
            'pensionToEnt' => 'Pension To Ent',
            'injuryInsurance' => 'Injury Insurance',
            'unemploymentToEnt' => 'Unemployment To Ent',
            'birthInsurance' => 'Birth Insurance',
            'medicareToEnt' => 'Medicare To Ent',
            'housingFundToEnt' => 'Housing Fund To Ent',
            'medicareOtherEnt' => 'Medicare Other Ent',
            'passMedicareOtherEnt' => 'Pass Medicare Other Ent',
            'medicareOtherEntTotal' => 'Medicare Other Ent Total',
            'medicareOtherEntTax' => 'Medicare Other Ent Tax',
            'retroactivePay' => 'Retroactive Pay',
            'areaSubsidy' => 'Area Subsidy',
            'plusSalary' => 'Plus Salary',
            'warmSubsidy' => 'Warm Subsidy',
            'bonus' => 'Bonus',
            'vacationAllowance' => 'Vacation Allowance',
            'aidInRemoteAreas' => 'Aid In Remote Areas',
            'holidayAllowance' => 'Holiday Allowance',
            'coolingAllowance' => 'Cooling Allowance',
            'salaryPreTaxsReissue' => 'Salary Pre Taxs Reissue',
            'salaryPreTaxDeductions' => 'Salary Pre Tax Deductions',
            'salaryAfterTaxReissue' => 'Salary After Tax Reissue',
            'salaryAfterTaxDeductions' => 'Salary After Tax Deductions',
            'otherPreTaxsReissue' => 'Other Pre Taxs Reissue',
            'otherAfterTaxReissue' => 'Other After Tax Reissue',
            'otherPreTaxDeductions' => 'Other Pre Tax Deductions',
            'otherAfterTaxDeductions' => 'Other After Tax Deductions',
            'salaryAdjust' => 'Salary Adjust',
            'otherDeductions' => 'Other Deductions',
            'otherWelPreTaxReissue' => 'Other Wel Pre Tax Reissue',
            'otherWelAfterTaxReissue' => 'Other Wel After Tax Reissue',
            'otherWelPreTaxDeductions' => 'Other Wel Pre Tax Deductions',
            'otherWelAfterTaxDeductions' => 'Other Wel After Tax Deductions',
            'otherAfterTaxSalary' => 'Other After Tax Salary',
            'annualPerBonus' => 'Annual Per Bonus',
            'yearEndBonus' => 'Year End Bonus',
            'otherBonus' => 'Other Bonus',
            'Allowancelift' => 'Allowancelift',
            'OtherPretaxdeduction' => 'Other Pretaxdeduction',
            'Suppinsurancelift' => 'Suppinsurancelift',
            'Afterreplacement' => 'Afterreplacement',
            'otherlacement' => 'Otherlacement',
            'otherldeduction' => 'Otherldeduction',
            'performance' => 'Performance',
            'year_work' => 'Year Work',
        ];
    }
    
    /**
     * 关联员工
     */
    public function getEmployee(){
       
        return $this->hasOne(Employee::className(), ['employee_number' => 'employee_number']);
    }
    
    /**
     * 员工薪资列表
     */
    public static function getList($field){
        $condition = $conditionFilter = [];
        
        
        if($employees = Yii::$app->request->get("employees")){
            $conditionFilter = ['or', ['like', Employee::tableName().'.name', $employees], ['like', Employee::tableName().'.employee_number', $employees]];
        }
        if($unit = Yii::$app->request->get("unit")){
            $condition[Employee::tableName() . ".unit_id"] = $unit;
        }
        if($department = Yii::$app->request->get("department")){
            $condition[Employee::tableName() . ".dep_id"] = $department;
        }
        if($rank = Yii::$app->request->get("rank")){
            $condition[Employee::tableName() . ".rank_id"] = $rank;
        }
        
        if($rank = Yii::$app->request->get("year")){
            $condition[self::tableName() . ".year"] = $rank;
        }
        
        if($rank = Yii::$app->request->get("month")){
            $condition[self::tableName() . ".month"] = $rank;
        }
        
        $condition[Employee::tableName() . ".is_work"] = 0;
        
        $data = self::find()->joinWith(["employee"])->where($condition)->andWhere($conditionFilter);

        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '10']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->select($field)->all();
       
        return [
              'model' => $model,
              'pages' => $pages,
        ];
               
    }
}
