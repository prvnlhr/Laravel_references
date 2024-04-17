php artisan make:model Flight

php artisan make:model Flight --migration

php artisan make:model Flight --factory

php artisan make:model Flight --seed

php artisan make:model Flight --controller



Flight::all() // The Eloquent all method will return all of the results in the model's table
$flights = DB::table('flights')->get(); // using DB facade


$email = User::where('name', 'John')->value('email');
$email = DB::table('users')->where('name', 'John')->value('email');


$emails = User::where('status', 'active')->pluck('email');
$titles = DB::table('users')->pluck('title', 'name');


DB::table('users')->orderBy('id')->chunk(100, function (Collection $users) {
foreach ($users as $user) {
// ...
}
});


$count = User::count();
$maxSalary = Employee::max('salary');
$minAge = User::min('age');
$totalRevenue = Order::sum('total_amount');
$averageRating = Product::avg('rating');
$exists = User::where('status', 'active')->exists();
$doesntExist = User::where('status', 'inactive')->doesntExist();
$customAggregate = User::selectRaw('SUM(salary) as total_salary')->first()->total_salary;


<!-- SELECT -->

$users = User::select('name', 'email as user_email')->get();
$users = User::distinct()->get();




<!-- WHERE -->

$user = User::where('id',1);
$user = USer::find(1)

$users = User::where([['status', '=', '1'],['subscribed', '<>', '1']])->get();


    $users = User::where('votes', '>', 100)->orWhere('name', 'John')->get(); SQL -> SELECT * FROM users WHERE votes > 100 OR name = 'John';


    $users = User::where('active', true)->where(function ($query) {
    $query->where('name', 'LIKE', 'Example%')->orWhere('email', 'LIKE', 'Example%')->orWhere('phone', 'LIKE', 'Example%');})->get();


    $users = User::whereIn('id', [1, 2, 3])->get();

    $activeUsers = User::where('is_active', 1)->pluck('id');
    $users = Comment::whereIn('user_id', $activeUsers)->get();

    $users = User::whereNotIn('id', [4, 5, 6])->get();

    $users = User::whereNotBetween('votes', [1, 100])->get();
    $users = User::whereBetween('votes', [1, 100])->get();

    $users = User::whereNull('updated_at')->get(); // SELECT * FROM users WHERE updated_at IS NULL;


    $users = User::whereNotNull('updated_at')->get(); // SELECT * FROM users WHERE updated_at IS NOT NULL;


    $users = User::whereDate('created_at', '2016-12-31')->get(); // SELECT * FROM users WHERE DATE(created_at) = '2016-12-31';


    $users = DB::table('users')->whereColumn('first_name', 'last_name')->get(); // SELECT * FROM users WHERE first_name = last_name;




    <!-- JOINS -->

    $users = User::join('posts', 'users.id', '=', 'posts.user_id')->select('users.*', 'posts.title')->get();

    $users = User::leftJoin('posts', 'users.id', '=', 'posts.user_id')->select('users.*', 'posts.title')->get();

    $users = User::rightJoin('posts', 'users.id', '=', 'posts.user_id')->select('users.*', 'posts.title') ->get();

    $users = User::crossJoin('posts')->select('users.*', 'posts.title')->get();



    <!-- UNION -->

    $activeUsers = User::select('id', 'name')->where('active', 1);

    $inactiveUsers = User::select('id', 'name')->where('active', 0);

    $users = $activeUsers->union($inactiveUsers)->get();


    <!-- ORDER BY -->

    $users = User::groupBy('role')->get();

    $users = User::orderBy('name', 'asc')->orderBy('email', 'desc')->get();

    $users = User::groupBy('account_id')->having('account_id', '>', 100)->get();
    $users = User::groupBy('account_id', 'status')->having('account_id', '>', 100)->get();


    <!-- LIMIT -->

    $users = User::limit(10)->get();

    <!-- OFFSET -->

    $users = User::offset(5)->get();


    $page = 2; // Assuming you want to retrieve the second page
    $perPage = 10; // Number of items per page

    $offset = ($page - 1) * $perPage;

    $users = User::offset($offset)->limit($perPage)->get();


    <!-- INSERT -->

    $user = new User();
    $user->email = 'kayla@example.com';
    $user->votes = 0;
    $user->save();


    User::insert([
    ['email' => 'picard@example.com', 'votes' => 0],
    ['email' => 'janeway@example.com', 'votes' => 0],
    ]);


    User::upsert(
    [
    ['email' => 'picard@example.com', 'votes' => 0],
    ['email' => 'janeway@example.com', 'votes' => 0],
    ],
    ['email'], // Unique column or columns
    ['votes'] // Columns to update
    );

    <!-- UPDATE -->

    $affected = User::where('id', 1)->update(['votes' => 1]);

    $user = User::updateOrCreate(
    ['email' => 'john@example.com'],
    ['name' => 'John', 'votes' => '2']
    );

    <!-- DELETE -->

    $deleted = User::truncate(); // Deletes all records in the users table

    $deleted = User::where('votes', '>', 100)->delete(); // Deletes records where votes are greater than 100


    <!-- INCREMENT/ DECREMENT -->

    User::increment('votes');

    User::increment('votes', 5);

    User::decrement('votes');

    User::decrement('votes', 5);