<?php

use App\Http\Resources\ProductRessource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Resources\CustomerRessource;
use App\Models\Customer;
use App\Http\Controllers\CustomerController;
use App\Http\Resources\ClaimRessource;
use App\Models\Claim;
use App\Http\Controllers\ClaimController;
use App\Models\User;
use App\Http\Resources\UserRessource;
use App\Http\Controllers\UserController;
use App\Models\Action;
use App\Http\Resources\ActionRessource;
use App\Http\Controllers\ActionController;
use App\Models\ActionComment;
use App\Http\Resources\ActionCommentRessource;
use App\Http\Controllers\ActionCommentController;
use App\Models\Team;
use App\Http\Resources\TeamRessource;
use App\Http\Controllers\TeamController;
use App\Models\Meeting;
use App\Http\Resources\MeetingRessource;
use App\Http\Controllers\MeetingController;
use App\Models\MeetingUser;
use App\Http\Resources\MeetingUserRessource;
use App\Http\Controllers\MeetingUserController;
use App\Models\FiveWhy;
use App\Http\Resources\FiveWhyRessource;
use App\Http\Controllers\FiveWhyController;
use App\Models\Result;
use App\Http\Resources\ResultRessource;
use App\Http\Controllers\ResultController;
use App\Models\FiveLigne;
use App\Http\Resources\FiveLigneRessource;
use App\Http\Controllers\FiveLigneController;
use App\Models\Ishikawa;
use App\Http\Resources\IshikawaRessource;
use App\Http\Controllers\IshikawaController;
use App\Models\Category;
use App\Http\Resources\CategoryRessource;
use App\Http\Controllers\CategoryController;
use App\Models\LabelChecking;
use App\Http\Resources\LabelCheckingRessource;
use App\Http\Controllers\LabelCheckingController;
use App\Models\Image;
use App\Http\Resources\ImageRessource;
use App\Http\Controllers\ImageController;
use App\Models\ProblemDescription;
use App\Http\Resources\ProblemDescriptionRessource;
use App\Http\Controllers\ProblemDescriptionController;
use App\Http\Controllers\AuthController;
use App\Models\Report;
use App\Http\Resources\ReportRessource;
use App\Http\Controllers\ReportController;
use App\Models\Annexe;
use App\Http\Resources\AnnexeRessource;
use App\Http\Controllers\AnnexeController;
use App\Models\Containement;
use App\Http\Resources\ContainementRessource;
use App\Http\Controllers\ContainementController;
use App\Models\Sorting;
use App\Http\Resources\SortingRessource;
use App\Http\Controllers\SortingController;
use App\Models\Effectiveness;
use App\Http\Resources\EffectivenessRessource;
use App\Http\Controllers\EffectivenessController;
use App\Models\TeamUser;
use App\Http\Resources\TeamUserRessource;
use App\Http\Controllers\TeamUserController;
use App\Http\Controllers\ExcelController;
use App\Http\Resources\ExcelRessource;
use App\Models\Excel;
use App\Http\Controllers\TestController;
use App\Http\Resources\TestRessource;
use App\Models\Test;
use App\Http\Controllers\NotificationController;

use App\Http\Resources\NotificationRessource;
use App\Models\Notification;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//  --------------------------------------------Customer--------------------------------------------------------------------
Route::get('/customers',function(){
    return CustomerRessource::collection(Customer::all());
});

Route::get('customer/{id}',function($id){
    return new CustomerRessource(Customer::findOrFail($id));
});
Route::get('/customers_activated',[CustomerController::class, 'getActivatedCustomers']);

Route::get('/products_by_customer/{id}',[CustomerController::class, 'getProductsByCustomer']);

Route::post('/customer',[CustomerController::class, 'store']);

Route::put('/customer/{id}',[CustomerController::class, 'update']);
Route::put('/customer_disactivated/{id}',[CustomerController::class, 'disactivate']);


Route::delete('/customer/{id}',[CustomerController::class, 'destroy']);
//  --------------------------------------------Product--------------------------------------------------------------------
Route::get('/products',function(){
    return ProductRessource::collection(Product::all());
});

Route::get('product/{id}',function($id){
    return new ProductRessource(Product::findOrFail($id));
});
Route::get('/products_activated',[ProductController::class, 'getActivatedProducts']);

Route::get('/customer_by_product/{id}',[ProductController::class, 'getCustomerNameByProductId']);
Route::get('/customer_id_by_name/{name}',[ProductController::class, 'getCustomerIdByName']);
Route::get('/products_join_customers',[ProductController::class, 'getProductsJoinCustomers']);

Route::post('/product',[ProductController::class, 'store']);

Route::put('/product/{id}',[ProductController::class, 'update']);
Route::put('/product_disactivated/{id}',[ProductController::class, 'disactivate']);

Route::delete('/product/{id}',[ProductController::class, 'destroy']);

//  --------------------------------------------Claim--------------------------------------------------------------------
Route::get('/claims',function(){
    return ClaimRessource::collection(Claim::all());
});

Route::get('claim/{id}',function($id){
    return new ClaimRessource(Claim::findOrFail($id));
});
Route::get('/claims_join',[ClaimController::class, 'getClaimsJoin']);
Route::get('/claim/{id}/team',[ClaimController::class, 'getTeamByClaim']);
Route::get('/claim/{id}/containement',[ClaimController::class, 'getContainementByClaim']);
Route::get('/claim/{id}/report',[ClaimController::class, 'getReportByClaim']);
Route::get('/claim/{id}/five_why',[ClaimController::class, 'getFiveWhyByClaim']);
Route::get('/claim/{id}/ishikawa',[ClaimController::class, 'getIshikawa']);

Route::get('/claim/{id}/label_checking',[ClaimController::class, 'getLabelCheckByClaim']);
Route::get('/claim/{id}/actions',[ClaimController::class, 'getActionsByClaim']);
Route::get('/claim/{id}/problem_description',[ClaimController::class, 'getProbDescByClaim']);
Route::get('/claim/{id}/label_checking_join',[ClaimController::class, 'getLabelCheckJoin']);
Route::get('/claim/{id}/report_join',[ClaimController::class, 'getReportJoin']);

Route::get('/claims_activated',[ClaimController::class, 'getActivatedClaims']);
Route::get('/claim/{id}/team_users',[ClaimController::class, 'getUsersOfTeam']);

Route::get('/claim/{claim_id}/team_meetings',[ClaimController::class, 'getMeetingsByClaim']);

Route::post('/claim',[ClaimController::class, 'store']);

Route::put('/claim/{id}',[ClaimController::class, 'update']);
Route::put('/claim_disactivated/{id}',[ClaimController::class, 'disactivate']);
Route::put('/claim_status/{id}',[ClaimController::class, 'updateStatus']);

Route::delete('/claim/{id}',[ClaimController::class, 'destroy']);


//  --------------------------------------------Users--------------------------------------------------------------------
Route::get('/users',function(){
    return UserRessource::collection(User::all());
});

Route::get('user/{id}',function($id){
    return new UserRessource(User::findOrFail($id));
});
Route::get('/users_activated',[UserController::class, 'getActivatedUsers']);

Route::post('/user',[UserController::class, 'store']);
Route::post('/send_email/{id}',[UserController::class, 'sendEmail']);

Route::put('/user/{id}',[UserController::class, 'update']);
Route::put('/user_disactivated/{id}',[UserController::class, 'disactivate']);

Route::delete('/user/{id}',[UserController::class, 'destroy']);
//  --------------------------------------------Actions--------------------------------------------------------------------
Route::get('/actions',function(){
    return ActionRessource::collection(Action::all());
});

Route::get('action/{id}',function($id){
    return new ActionRessource(Action::findOrFail($id));
});
Route::get('/actions_activated/{report_id}',[ActionController::class, 'getActivatedActions']);
Route::get('/report/{report_id}/implemented_actions',[ActionController::class, 'getImplementedActions']);
Route::get('/report/{report_id}/preventive_actions',[ActionController::class, 'getPreventiveActions']);
Route::get('/report/{report_id}/potential_actions',[ActionController::class, 'getPotentialActions']);
Route::get('/user/{user_id}/actions_join_claims',[ActionController::class, 'getActions_join_claims']);
Route::get('/user/{user_id}/actions_not_started',[ActionController::class, 'getNumberOfActionsNotStarted']);



Route::post('/action',[ActionController::class, 'store']);

Route::put('/action/{id}',[ActionController::class, 'update']);
Route::put('/action_disactivated/{id}',[ActionController::class, 'disactivate']);
Route::put('/action/{id}/update_status',[ActionController::class, 'updateStatus']);

Route::delete('/action/{id}',[ActionController::class, 'destroy']);
//--------------------------------------------ActionComment--------------------------------------------------------------------
Route::get('/action_comments',function(){
    return ActionCommentRessource::collection(ActionComment::all());
});

Route::get('action_comment/{id}',function($id){
    return new ActionCommentRessource(ActionComment::findOrFail($id));
});
Route::get('/action/{action_id}/comments',[ActionCommentController::class, 'getComments']);

Route::post('/action_comment',[ActionCommentController::class, 'store']);

Route::put('/action_comment/{id}',[ActionCommentController::class, 'update']);

Route::delete('/action_comment/{id}',[ActionCommentController::class, 'destroy']);
//--------------------------------------------Team--------------------------------------------------------------------
Route::get('/teams',function(){
    return TeamRessource::collection(Team::all());
});

Route::get('team/{id}',function($id){
    return new TeamRessource(Team::findOrFail($id));
});


Route::post('/team',[TeamController::class, 'store']);

Route::put('/team/{id}',[TeamController::class, 'update']);

Route::delete('/team/{id}',[TeamController::class, 'destroy']);

//--------------------------------------------TeamUser--------------------------------------------------------------------
Route::get('/team_users',function(){
    return TeamUserRessource::collection(TeamUser::all());
});

Route::get('team_user/{id}',function($id){
    return new TeamUserRessource(TeamUser::findOrFail($id));
});

Route::post('/add-user-to-team', [TeamUserController::class, 'addUserToTeam']);
Route::post('/add-leader', [TeamUserController::class, 'addLeader']);


Route::put('/team_user/{id}',[TeamUserController::class, 'update']);
Route::put('/team/{team_id}/user_disactivated/{user_id}',[TeamUserController::class, 'disactivate']);

Route::delete('/team_user/{id}',[TeamUserController::class, 'destroy']);

//--------------------------------------------Meeting--------------------------------------------------------------------
Route::get('/meetings',function(){
    return MeetingRessource::collection(Meeting::all());
});

Route::get('meeting/{id}',function($id){
    return new MeetingRessource(Meeting::findOrFail($id));
});
Route::get('/meetings_activated',[MeetingController::class, 'getActivatedMeetings']);

Route::post('/claim/{id}/meeting',[MeetingController::class, 'store']);

Route::put('/meeting/{id}',[MeetingController::class, 'update']);
Route::put('/meeting_disactivated/{id}',[MeetingController::class, 'disactivate']);

Route::delete('/meeting/{id}',[MeetingController::class, 'destroy']);
//--------------------------------------------MeetingUser--------------------------------------------------------------------
Route::get('/meeting_users',function(){
    return MeetingUserRessource::collection(MeetingUser::all());
});

Route::get('meeting_user/{id}',function($id){
    return new MeetingUserRessource(MeetingUser::findOrFail($id));
});
Route::get('/meeting/{meeting_id}/absences', [MeetingUserController::class, 'getAbsences']);


Route::post('/meeting_user',[MeetingUserController::class, 'store']);

Route::put('/meeting_user/{id}',[MeetingUserController::class, 'update']);

Route::delete('/meeting_user/{id}',[MeetingUserController::class, 'destroy']);


//--------------------------------------------FiveWhy--------------------------------------------------------------------
Route::get('/five_whys',function(){
    return FiveWhyRessource::collection(FiveWhy::all());
});

Route::get('five_why/{id}',function($id){
    return new FiveWhyRessource(FiveWhy::findOrFail($id));
});
Route::get('/claim/{claim_id}/five_why',[FiveWhyController::class, 'getFiveWhyByClaim']);

Route::post('/five_why',[FiveWhyController::class, 'store']);

Route::put('/five_why/{id}',[FiveWhyController::class, 'update']);

Route::delete('/five_why/{id}',[FiveWhyController::class, 'destroy']);

//--------------------------------------------Result--------------------------------------------------------------------
Route::get('/results',function(){
    return ResultRessource::collection(Result::all());
});

Route::get('result/{id}',function($id){
    return new ResultRessource(Result::findOrFail($id));
});
Route::get('/claim/{claim_id}/results',[ResultController::class, 'getResultsByClaim']);

Route::post('/result',[ResultController::class, 'store']);

Route::put('/result/{id}',[ResultController::class, 'update']);
Route::put('/results/{five_why_id}',[ResultController::class, 'updateFiveWhyResults']);
Route::delete('/result/{id}',[ResultController::class, 'destroy']);
//--------------------------------------------FiveLigne--------------------------------------------------------------------
Route::get('/five_lignes',function(){
    return FiveLigneRessource::collection(FiveLigne::all());
});

Route::get('five_ligne/{id}',function($id){
    return new FiveLigneRessource(FiveLigne::findOrFail($id));
});
Route::get('/claim/{claim_id}/five_lignes',[FiveLigneController::class, 'getFiveLignesByClaim']);
Route::get('/claim/{claim_id}/five_lignes_detection',[FiveLigneController::class, 'getFiveLignesDetection']);
Route::get('/claim/{claim_id}/five_lignes_occurence',[FiveLigneController::class, 'getFiveLignesOccurence']);
Route::get('/claim/{claim_id}/five_lignes_system',[FiveLigneController::class, 'getFiveLignesSystem']);

Route::post('/five_ligne',[FiveLigneController::class, 'store']);

Route::put('/five_ligne/{id}',[FiveLigneController::class, 'update']);

Route::delete('/five_ligne/{id}',[FiveLigneController::class, 'destroy']);
//--------------------------------------------LabelChecking--------------------------------------------------------------------
Route::get('/label_checkings',function(){
    return LabelCheckingRessource::collection(LabelChecking::all());
});

Route::get('label_checking/{id}',function($id){
    return new LabelCheckingRessource(LabelChecking::findOrFail($id));
});

Route::post('/label_checking',[LabelCheckingController::class, 'store']);

Route::put('/label_checking/{id}',[LabelCheckingController::class, 'update']);

Route::delete('/label_checking/{id}',[LabelCheckingController::class, 'destroy']);



//--------------------------------------------Ishikawa--------------------------------------------------------------------
Route::get('/ishikawas',function(){
    return IshikawaRessource::collection(Ishikawa::all());
});

Route::get('ishikawa/{id}',function($id){
    return new IshikawaRessource(Ishikawa::findOrFail($id));
});
Route::post('/ishikawa',[IshikawaController::class, 'store']);

Route::put('/ishikawa/{id}',[IshikawaController::class, 'update']);

Route::delete('/ishikawa/{id}',[IshikawaController::class, 'destroy']);


//--------------------------------------------Category--------------------------------------------------------------------
Route::get('/categories',function(){
    return CategoryRessource::collection(Category::all());
});

Route::get('category/{id}',function($id){
    return new CategoryRessource(Category::findOrFail($id));
});
Route::get('/ishikawa/{ishikawa_id}/categories',[CategoryController::class, 'getCategories']);

Route::post('/category',[CategoryController::class, 'store']);

Route::put('/category/{id}',[CategoryController::class, 'update']);

Route::delete('/category/{id}',[CategoryController::class, 'destroy']);


//--------------------------------------------Image--------------------------------------------------------------------
Route::get('/images',function(){
    return ImageRessource::collection(Image::all());
});

Route::get('image/{id}',function($id){
    return new ImageRessource(Image::findOrFail($id));
});

Route::get('/label_checking/{label_id}/image',[ImageController::class, 'getImageOfLabelChecking']);
Route::get('/problem_description/{id}/images',[ImageController::class, 'getImgagesOfProblemDescription']);
Route::get('/report/{id}/images',[ImageController::class, 'getImgagesOfReport']);

Route::post('/image',[ImageController::class, 'store']);

Route::put('/image/{id}',[ImageController::class, 'update']);

Route::post('/add_image',[ImageController::class, 'addImage']);

Route::delete('/image/{id}',[ImageController::class, 'destroy']);


//--------------------------------------------ProblemDescription--------------------------------------------------------------------
Route::get('/problem_descriptions',function(){
    return ProblemDescriptionRessource::collection(ProblemDescription::all());
});

Route::get('problem_description/{id}',function($id){
    return new ProblemDescriptionRessource(ProblemDescription::findOrFail($id));
});
Route::post('/problem_description',[ProblemDescriptionController::class, 'store']);

Route::put('/problem_description/{id}',[ProblemDescriptionController::class, 'update']);

Route::delete('/problem_description/{id}',[ProblemDescriptionController::class, 'destroy']);

//--------------------------------------------8D_Report--------------------------------------------------------------------
Route::get('/reports',function(){
    return ReportRessource::collection(Report::all());
});

Route::get('report/{id}',function($id){
    return new ReportRessource(Report::findOrFail($id));
});
Route::post('/report',[ReportController::class, 'store']);

Route::put('/report/{id}',[ReportController::class, 'update']);

Route::delete('/report/{id}',[ReportController::class, 'destroy']);


//--------------------------------------------Annexe--------------------------------------------------------------------
Route::get('/annexes',function(){
    return AnnexeRessource::collection(Annexe::all());
});

Route::get('annexe/{id}',function($id){
    return new AnnexeRessource(Annexe::findOrFail($id));
});
Route::post('/annexe',[AnnexeController::class, 'store']);

Route::put('/annexe/{id}',[AnnexeController::class, 'update']);

Route::delete('/annexe/{id}',[AnnexeController::class, 'destroy']);

//--------------------------------------------Containement--------------------------------------------------------------------
Route::get('/containements',function(){
    return ContainementRessource::collection(Containement::all());
});

Route::get('containement/{id}',function($id){
    return new ContainementRessource(Containement::findOrFail($id));
});
Route::get('/containement/{id}/sortings',[ContainementController::class, 'getSortingByContainement']);

Route::post('/containement',[ContainementController::class, 'store']);

Route::put('/containement/{id}',[ContainementController::class, 'update']);

Route::delete('/containement/{id}',[ContainementController::class, 'destroy']);

//--------------------------------------------Sorting_List--------------------------------------------------------------------
Route::get('/sortings',function(){
    return SortingRessource::collection(Sorting::all());
});

Route::get('sorting/{id}',function($id){
    return new SortingRessource(Sorting::findOrFail($id));
});
Route::post('/sorting',[SortingController::class, 'store']);

Route::put('/sorting/{id}',[SortingController::class, 'update']);

Route::delete('/sorting/{id}',[SortingController::class, 'destroy']);

//--------------------------------------------Effectiveness--------------------------------------------------------------------
Route::get('/effectivenesses',function(){
    return EffectivenessRessource::collection(Effectiveness::all());
});

Route::get('effectiveness/{id}',function($id){
    return new EffectivenessRessource(Effectiveness::findOrFail($id));
});
Route::post('/effectiveness',[EffectivenessController::class, 'store']);

Route::put('/effectiveness/{id}',[EffectivenessController::class, 'update']);

Route::delete('/effectiveness/{id}',[EffectivenessController::class, 'destroy']);

//--------------------------------------------------------------Login-----------------------------------------------------------------------



Route::post('/login', [AuthController::class,'login']);


Route::group(['middleware'=>'api'],function(){
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::get('me', [AuthController::class,'me']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//-------------------------------------------------------------------Excel ----------------------------------------------------
Route::get('/populate-excel', 'App\Http\Controllers\ExcelController@populateExcel');
Route::get('/download-excel', [ExcelController::class],'downloadExcel');
Route::get('/excels',function(){
    return ExcelRessource::collection(Excel::all());
});
Route::get('excel/{id}',function($id){
    return new ExcelRessource(Excel::findOrFail($id));
});


//--------------------------------------------Notifications--------------------------------------------------------------------
Route::get('/notifications',function(){
    return NotificationRessource::collection(Notification::all());
});

Route::get('notification/{id}',function($id){
    return new NotificationRessource(Notification::findOrFail($id));
});
Route::get('user/{user_id}/notifications',[NotificationController::class, 'getNotificationsOfUser']);
Route::get('user/{user_id}/notifications_number',[NotificationController::class, 'getNumberOfNotifications']);

Route::post('/notification',[NotificationController::class, 'store']);
Route::put('/notification/{id}',[NotificationController::class, 'update']);
Route::delete('/notification/{id}',[NotificationController::class, 'destroy']);

