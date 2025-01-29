use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\SearchSuggestionController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Department routes
Route::get('/regions/{region}/departments', [DepartmentController::class, 'byRegion']);

// Category routes
Route::get('/categories', [CategoryController::class, 'index']);

// Search routes
Route::get('/search/suggestions', [SearchSuggestionController::class, 'suggest']);
Route::post('/search/save', [SearchSuggestionController::class, 'saveSearch']); 