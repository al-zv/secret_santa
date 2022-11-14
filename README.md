### [1. Задание PostgreSql](#PostgreSql)

### [2. Задание Laravel](#Laravel)

## <a name="PostgreSql">1. Задание PostgreSql</a> 

Есть таблица users, user_carts, orders, order_items

Реализовать связь этих таблиц.

Написать запрос создания всех 4 таблиц со связями.

Написать запрос добавления тестовых данных в эти таблицы.

Написать запрос для вывода одной таблицы, которая содержит эти данные:

user.id , user.name , orders.id , order_items.id, order_items.name, orders.created_at

Написать запрос удаления. Запрос должен удалять пользователя, корзину и все его заказы. DELETE FROM users WHERE id = 1;


## Решение

Написать запрос создания всех 4 таблиц со связями.

    CREATE TABLE users (
      id integer PRIMARY KEY,
      name varchar (100)
    );

    CREATE TABLE user_carts (
      id integer PRIMARY KEY,
      user_id integer REFERENCES users ON DELETE CASCADE,
      name varchar (150),
      count integer
    );

    CREATE TABLE orders (
      id integer PRIMARY KEY,
      user_id integer REFERENCES users ON DELETE CASCADE,
      order_number integer,
      created_at timestamp
    );
    
    CREATE TABLE order_items (
      id integer PRIMARY KEY,
      order_id integer REFERENCES orders ON DELETE CASCADE,
      name varchar (150),
      count integer
    );

<img width="570" alt="CREATE TABLE users" src="https://user-images.githubusercontent.com/63869857/201619442-e5c763df-2bcf-4338-a166-2a0519e99842.png">


Написать запрос добавления тестовых данных в эти таблицы.

    INSERT INTO users VALUES 
      (1, 'Mark'),
      (2, 'Петр'),
      (3, 'Евгений');

    INSERT INTO user_carts VALUES 
      (1, 1, 'телефон', 1),
      (2, 1, 'ноутбук', 1),
      (3, 2, 'часы', 1),
      (4, 2, 'флешка', 2),
      (5, 3, 'видеокамера', 1);
      
    INSERT INTO orders VALUES 
      (1, 1, 1114, '2022-11-13 18:23:54+05'),
      (2, 2, 1214, '2022-11-13 21:23:54+05'),
      (3, 2,  12141, '2022-11-14 08:23:54+05'),
      (4, 3,  1314, '2022-11-14 10:31:54+05');
      
    INSERT INTO order_items VALUES 
      (1, 1, 'холодильник', 1),
      (2, 1, 'морозильная установка', 1),
      (3, 1, 'хладагент', 2),
      (4, 2, 'принтер', 1),
      (5, 3, 'картридж аа33', 1),
      (6, 4, 'мотолок', 5),
      (7, 4, 'набор инструментов', 2),
      (8, 4, 'бензопила', 3),
      (9, 4, 'сварочный аппарат', 1);  
    
<img width="675" alt="Pasted Graphic 1" src="https://user-images.githubusercontent.com/63869857/201619994-30909297-c3b0-4173-92ac-f4411f96a30f.png">
    
    
Написать запрос для вывода одной таблицы, которая содержит эти данные:
user.id , user.name , orders.id , order_items.id, order_items.name, orders.created_at

    SELECT users.id as users_id, users.name as users_name, 
      orders.id as orders_id, order_items.id as order_items_id, 
      order_items.name as order_items_name, orders.created_at as orders_created_at 
      FROM users, orders, order_items 
      WHERE users.id = orders.user_id AND orders.id = order_items.order_id;
    
<img width="878" alt="Pasted Graphic 2" src="https://user-images.githubusercontent.com/63869857/201620421-50e1e9bc-e95a-4a3a-84db-0494eaa9a807.png">


Написать запрос удаления. Запрос должен удалять пользователя, корзину и все его заказы. DELETE FROM users WHERE id = 1;

   DELETE FROM users WHERE id = 1;
   
   
<img width="878" alt="Pasted Graphic 3" src="https://user-images.githubusercontent.com/63869857/201621203-ccceff4b-3a20-43bc-b869-7f080c0bd4ef.png">


## <a name="Laravel">2. Задание Laravel.</a> 

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
Реализовать один get метод, который по переданному в get параметре id участника вернёт json информацию о подопечном (поля записи из таблицы) и о самом участнике.

"Тайный Санта", он же Secret Santa, - анонимный способ дарить подарки. Идея проста: в большой компании каждому достаётся один "подопечный",
которому нужно придумать подарок. Сам даритель при этом остаётся тем самым "тайным Сантой".

## Инструкция по запуску проекта

Скачать с GitHub

    git clone https://github.com/al-zv/secret_santa.git
    
Запустить проекта через Docker (Docker должен быть установлен и запущен)

    ./vendor/bin/sail up -d

Выполнить миграции

    ./vendor/bin/sail artisan migrate

Запустить сидеры

    ./vendor/bin/sail artisan db:seed

## Работа с проектом

Запустить get запрос, который по переданному в get параметре id участника вернёт json информацию о подопечном (поля записи из таблицы) и о самом участнике.

Для лучшего отображения данных лучше выполнить get запрос в Postman (бесплатный инструмент для тестирования API) или в любом подобном инструменте.

    http://localhost/api/1

Всего в базу данных добавляется 40 записей, поэтому до 40-го id запрос выдаст данные о участнике и подопечном.

Выполненный get запрос в Postman

<img width="856" alt="image" src="https://user-images.githubusercontent.com/63869857/201627443-e55592fe-d446-4bcb-8bef-eb5065005a1b.png">

Также по запросу http://localhost/api/members можно получить список всех участников

<img width="856" alt="image" src="https://user-images.githubusercontent.com/63869857/201638139-833cc80e-deda-4328-9600-39b17332aab4.png">

## Код проекта

### Миграции

______

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
    
_______ 
    
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
    
 ### Сидеры
 
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
    
 _____
 
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
    
______

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

### Маршруты

    Route::get('/members', [MemberController::class, 'show']);
    
    Route::get('/{id}', [SecretSantaController::class, 'get']);

### Модели

____

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
    
 ____
 
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

### Контроллеры

_____

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
    
______

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

### Что можно улучшить

- Сделать таблицу многие ко многим участник_подопечный. (Получается будут таблицы участники, подопечные, и участник_подопечный)
- Убрать из docker лишние образы.
- Заполнить данные о учатсниках в понимаемом человеку виде (вроде это можно через фабрики сделать).
- Применить фабрики для заполнения данных.
