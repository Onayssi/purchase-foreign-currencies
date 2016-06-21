<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Branches;
use app\models\UserTypes;

/* @var $this yii\web\View */
$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-branches">
    <h1><?= Html::encode($this->title) ?></h1>
<?php if(@$user){
	// case of edit/add action
	?>
<div class="col-lg-5">
<?php
// creation of form group for add and edit record
$form = ActiveForm::begin([
    'id' => 'user-form',
    'options' => ['class' => 'form-horizontal'],
	'action' => Url::to('index.php?r=site/users')
]) ?>
   <?php 
   // if action equal add
   if($user=="new"){
   ?>
    <?= $form->field($model, 'branch', ['inputOptions' => ['class' => 'selectpicker']])->dropDownList(Branches::getBranchesByCompanies(), ['prompt' => 'Select a Branch', 'class'=>'form-control required']);
?>
    <?= $form->field($model, 'fullname')->label('Full Name');?>
    <?= $form->field($model, 'gender')->dropDownList(['Male'=>'Male', 'Female'=>'Female'], ['prompt' => 'Select a Gender']); ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'password')->passwordInput(); ?>
    <?php $usertypes = ArrayHelper::map(UserTypes::find()->all(), 'id', 'role');?>
    <?= $form->field($model, 'type')->dropDownList($usertypes, ['prompt' => 'Select a Role']); ?>
    <?= $form->field($model, 'active')->checkbox(['value'=>'yes', 'uncheck'=>'no']);?>
    <!-- update and delete actions -->
    <input type="hidden" name="opt" value="save" />
    <input type="hidden" name="action" value="add" />
    <div class="form-group">
        <div align="right">
        <!-- submit form button -->
            <?= Html::submitButton('Add', ['class' => 'btn btn-primary']) ?>
        </div>
    </div> 
    <?php
   }else{
	   // case of edit user action
   $model->fullname = $user['fullname'];
   $model->email = $user['email'];
   $model->password = $user['password']; 
   $model->gender = $user['gender']; 
   $model->active = $user['active']; 
   $model->type = $user['type']; 
   $model->branch = $user['branch_id'];   
   ?>
   <!-- select box list width opt group to display list of branches with parent companies -->
   <?= $form->field($model, 'branch', ['inputOptions' => ['class' => 'selectpicker']])->dropDownList(Branches::getBranchesByCompanies(), ['prompt' => 'Select a Branch', 'class'=>'form-control required']);
?>
    <?= $form->field($model, 'fullname') ?>
    <!-- select box list with static values (Male/Female) -->
    <?= $form->field($model, 'gender')->dropDownList(['Male'=>'Male', 'Female'=>'Female'], ['prompt' => 'Select a Gender']); ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <!-- select box list to display list of user types -->
    <?php $usertypes = ArrayHelper::map(UserTypes::find()->all(), 'id', 'role');?>
    <?= $form->field($model, 'type')->dropDownList($usertypes, ['prompt' => 'Select a Role']); ?>
     <!-- set activity of user (yes/no) -->
    <?= $form->field($model, 'active')->checkbox(['value'=>'yes', 'uncheck'=>'no']);?>
    <input type="hidden" name="opt" value="save" />
    <input type="hidden" name="action" value="edit" />
    <input type="hidden" name="id" value="<?=Yii::$app->request->get('id')?>" />
    <div class="form-group">
        <div align="right">
            <!-- submit action button -->
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php }?>
<?php ActiveForm::end() ?>

<!-- back button -->
<div align="center">
 <!-- list all users -->
   <a role="button" class="btn btn-success" href="<?=Url::to(['site/users']);?>">List all records</a>
</div>
</div>
<?php }else{?>    
         <div class="form-group">
         <!-- show notification message when existed (email should be unique for an user)-->
          <?php if(Yii::$app->session->hasFlash('error_mail_exists')){?>
	      <div class="alert alert-danger">
   	      <a href="#" class="close" data-dismiss="alert">&times;</a>
   	      <strong>Error!</strong> <?= Yii::$app->session->getFlash('error_mail_exists');?>
	      </div>  
          <?php }?>
        <div align="right">
        <!--  add new record button -->
            <a role="button" class="btn btn-primary" href="<?=Url::to(['site/users', 'opt' => 'add']);?>">Add New Record</a>
        </div>
    </div>
    <!-- listing all records -->
    <!-- Display table view [we can use a datagrid widget from yii extensions -->
    <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" class="activerecords">
    <th>Full Name</th>
    <th>Gender</th>
    <th>Email Address</th>
    <th>User Type</th>
    <th>Branch</th>
    <th>Active</th>
    <th>Actions</th>
    <?php foreach ($users as $user): ?>
        <tr>
        <td>
            <?= Html::encode("{$user->fullname}") ?>
        </td> 
        <td>
            <?= Html::encode("{$user->gender}") ?>
        </td> 
        <td>
            <?= Html::a("{$user->email}","mailto:{$user->email}", ['target' => '_blank']); ?>
        </td> 
        <td>
            <?php $user_type = UserTypes::findOne($user->type);?>
            <?= $user_type["role"]; ?>
        </td>        
        <td>  
            <?php $branch_value = Branches::findOne($user->branch_id);?>
            <?= $branch_value["name"]; ?>
        </td>  
        <td>
            <?= ucfirst(Html::encode("{$user->active}")); ?>
        </td>
        <td>
        <!-- add & edit links -->
		<a href="<?= Url::to(['site/users', 'opt' => 'edit', 'id' => $user->id])?>">Edit</a>&nbsp;|&nbsp;<?= Html::tag('a', "Delete",['href'=>'index.php?r=site/users&opt=delete&id='.$user->id,'onclick' => 'return delete_confirmation()']) ?>
        </td>   
        </tr>
    <?php endforeach; ?>
    </table>

<?php }?>
	<br clear="all" />
    <!-- alert  msg confirmation when deleting record -->
    <script type="text/javascript">
    function delete_confirmation(){
	if(confirm("Are you sure?\nYou want to delete this record?")) return true;
	return false;	
	}
    </script>
    
</div>
