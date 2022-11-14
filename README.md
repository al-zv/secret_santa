### [1. Задание PostgreSql](#PostgreSql)







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
    
## <a name="PostgreSql">Задание PostgreSql</a> 
    
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
