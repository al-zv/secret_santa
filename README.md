### [Проект на Laravel: реализация логики работы игры "Тайный санта"](#Laravel)
#### [1. Инструкция по запуску проекта](#21)
#### [2. Работа с проектом](#22)
#### [3. Код проекта](#23)
#### [3.1. Миграции](#24)
#### [3.2. Сидеры](#25)
#### [3.3. Маршруты](#26)
#### [3.4. Модели](#27)
#### [3.5. Контроллеры](#28)
#### [4. Что можно улучшить](#29)
#### [5. Добавлено в проект](#30)
#### [5.1. Заполнение фейковыми данными через фабрики](#31)

## <a name="Laravel">Проект на Laravel: реализация логики работы игры "Тайный санта"</a> 

Общие указания:

Код задачи должен быть выложен на GitHub.

Схема базы данных должна заполняться через миграции.

Данные базы данных должны наполняться случайным образом (генерировать фамилии и имена и связку санта-подопечный) через db:seed

Задача:
Реализовать логику работы игры "тайный санта"
На laravel необходмио заполнить тестовыми данными базу данных (через db:seed)
В базе данных должна быть таблица с участниками. Каждый участник является "тайным сантой" для другого участника (подопечного).
У каждого участника есть строго один тайный санта и один подопечный, для которого участник является тайным сантой.
У каждого участника есть уникальное имя.
Реализовать один get метод, который по переданному в get параметру id участника вернёт json информацию о подопечном (поля записи из таблицы) и о самом участнике.

"Тайный Санта", он же Secret Santa, - анонимный способ дарить подарки. Идея проста: в большой компании каждому достаётся один "подопечный",
которому нужно придумать подарок. Сам даритель при этом остаётся тем самым "тайным Сантой".

### <a name="21">1. Инструкция по запуску проекта</a> 

Скачать с GitHub

    git clone https://github.com/al-zv/secret_santa.git
    
Запустить проект через Docker (Docker должен быть установлен и запущен)

    ./vendor/bin/sail up -d

Выполнить миграции

    ./vendor/bin/sail artisan migrate

Запустить сидеры

    ./vendor/bin/sail artisan db:seed

### <a name="22">2. Работа с проектом</a> 

Запустить get запрос, который по переданному в get параметру id участника вернёт json информацию о подопечном (поля записи из таблицы) и о самом участнике.

Для лучшего отображения данных лучше выполнить get запрос в Postman (бесплатный инструмент для тестирования API) или в любом подобном инструменте.

    http://localhost/api/1

Всего в базу данных добавляется 40 записей, поэтому до 40-го id запрос выдаст данные о участнике и подопечном.

Выполненный get запрос в Postman

<img width="856" alt="image" src="https://user-images.githubusercontent.com/63869857/201627443-e55592fe-d446-4bcb-8bef-eb5065005a1b.png">

Также по запросу http://localhost/api/members можно получить список всех участников

<img width="856" alt="image" src="https://user-images.githubusercontent.com/63869857/201638139-833cc80e-deda-4328-9600-39b17332aab4.png">

### <a name="23">3. Код проекта</a>

#### <a name="24">3.1. Миграции</a>

*файл secret_santa/database/migrations/2022_11_13_123754_create_members_table.php*

     /**
     * Таблица участников.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('profession');
            $table->string('desired_gift');
            $table->timestamps();
        });
    }
    
*файл secret_santa/database/migrations/2022_11_13_140201_create_secret_santas_table.php*
    
     /**
     * Таблица подопечных.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secret_santas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()
            ->onDelete('cascade');
            $table->timestamps();
        });
    }
 
 #### <a name="25">3.2. Сидеры</a>
 
 *файл secret_santa/database/seeders/DatabaseSeeder.php*
 
    class DatabaseSeeder extends Seeder
    {
        /**
         * Гланый сидер запускает заполение таблиц участников и подопечных.
         *
         * @return void
         */
        public function run()
        {
            $this->call([MemberSeeder::class]);
            $this->call([SecretSantaSeeder::class]);
        }
    }
    
*файл secret_santa/database/seeders/MemberSeeder.php*
 
    class MemberSeeder extends Seeder
    {
        /**
         * Заполняются 40 участников, для формирования имени, профессии
         *  и желаемого подарка примяется функция random класса Str 
         * (заполняются случайным символьно-цифровым набором).
         *
         * @return void
         */
        public function run()
        {
            for ($i = 0; $i < 40; $i++) {
                DB::table('members')->insert([
                    'name' => Str::random(5),
                    'profession' => Str::random(8),
                    'desired_gift' => Str::random(10),
                ]);
            }
        }
    }
    
*файл secret_santa/database/seeders/SecretSantaSeeder.php*

    class SecretSantaSeeder extends Seeder
    {
        /**
         * Для каждого участника заполняется подопечный:
         * для первого участника выбирается последний подопечный из списка участников
         * и так далее.
         * Стоблец id таблицы подопечные (secret_santas) соответствует 
         * стоблцу id таблицы участников members.
         * Стобец member_id соответствует id подопечному.
         *
         * @return void
         */
        public function run()
        {
            $i = Member::count();
            for ($i; $i > 0; $i--) {
                DB::table('secret_santas')->insert([
                    'member_id' => $i,
                ]);
            }
        }
    }

#### <a name="26">3.3. Маршруты</a>

*файл secret_santa/routes/api.php*

    Route::get('/members', [MemberController::class, 'show']);
    
    Route::get('/{id}', [SecretSantaController::class, 'get']);

#### <a name="27">3.4. Модели</a>

*файл secret_santa/app/Models/Member.php*

    class Member extends Model
    {
        use HasFactory;

        /**
         * Связь один к одному с моделью тайный санта
         */

        public function secretSanta()
        {
            return $this->hasOne(SecretSanta::class);
        }
    }
    
 *файл secret_santa/app/Models/SecretSanta.php*
 
 class SecretSanta extends Model
{
    use HasFactory;

    /**
     * Обратная связь один к одному с моделью участники
     */

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}

#### <a name="28">3.5. Контроллеры</a>

*файл secret_santa/app/Http/Controllers/MemberController.php*

    class MemberController extends Controller
    {

        /**
         * Получить всех участников.
         *
         * @return \Illuminate\Http\Response
         */

        public function show() {
            $members = Member::get();
            return response()->json($members, 200);
        }
    }
    
*файл secret_santa/app/Http/Controllers/SecretSantaController.php*

    class SecretSantaController extends Controller
    {

        /**
         * Получить по id участника информации о участнике и подопечном.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */

        public function get(Request $request) {
            $member = Member::find($request->id);
            $ward_id = $member->secretSanta()->first();
            $ward = Member::find($ward_id->id);
            return response()->json(['участник' => $member, 'подопечный' => $ward], 200);

        }
    }

### <a name="29">4. Что можно улучшить</a>

- Сделать таблицу многие ко многим участник_подопечный. (Получается будут таблицы участники, подопечные, и участник_подопечный)
- Убрать из docker лишние образы.
- Заполнить данные об участниках в понимаемом человеку виде (вроде это можно через фабрики сделать).
- Применить фабрики для заполнения данных.

### <a name="30">5. Добавлено в проект</a>

### <a name="31">5.1. Заполнение фейковыми данными через фабрики</a>

Применение фабрик для заполнения фейковыми данными таблиц БД через Seeder (библиотека FakerPHP).

Как работает механизм заполнения фейковыми данными через фабрики

- создание фабрики (название должно быть аналогично модели):

    ./vendor/bin/sail artisan make:factory Member
    
- программирование фабрики:

*файл secret_santa/database/factories/MemberFactory.php*

    namespace Database\Factories;

    use Illuminate\Database\Eloquent\Factories\Factory;

    /**
     * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
     */
    class MemberFactory extends Factory
    {
        /**
         * Define the model's default state.
         *
         * @return array<string, mixed>
         */
        public function definition()
        {
            return [
                'name' => $this->faker->name(),
                'profession' => $this->faker->word(),
                'desired_gift' => $this->faker->word(),
            ];
        }
    }

- в модели по умолчанию дабавлены строчки (use Illuminate\Database\Eloquent\Factories\HasFactory и use HasFactory), которые применяются для применения фабрики через модели):

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use App\Models\SecretSanta;

    class Member extends Model
    {
        use HasFactory;
    }

- в сидере через модель заполняются фейковые данные в таблице БД:

*файл secret_santa/app/Models/Member.php*

    namespace Database\Seeders;

    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Str;
    use App\Models\Member;

    class MemberSeeder extends Seeder
    {
        /**
         * Заполняются 40 участников, для формирования имени, профессии
         *  и желаемого подарка применяется фабрика, которая использует библиотеку FakerPHP.
         *
         * @return void
         */
        public function run()
        {        
            Member::factory()
                    ->count(40)
                    ->create();
        }
    }
