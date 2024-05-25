# 1.재료
create table ingredient (
	ingredient_id int,
    origin varchar(20),
    ingredient_name varchar(20),
    primary key(ingredient_id)
);

# 2.코너
create table corner (
	corner_id int,
    corner_name varchar(20),
    primary key(corner_id)
);

# 3.메뉴
create table menu (
	menu_id int unique,
    menu_name varchar(30),
    menu_descript tinytext,
    calorie int check (calorie > 0),
    price int,
    corner_id int not null,
    primary key(menu_id),
    foreign key(corner_id) references corner(corner_id)
);

# 4.메뉴재료
create table components (
	menu_id int,
    ingredient_id int,
    primary key(menu_id, ingredient_id),
    foreign key(menu_id) references menu(menu_id),
	foreign key(ingredient_id) references ingredient(ingredient_id)
);

# 5.고객 
create table customer (
	customer_id int,
    customer_name varchar(20),
    phone char(13),
	residence_registration_number char(14) not null,
    email varchar(30),
    address varchar(50),
    position varchar(10),
    points int default 0,
    primary key(customer_id)
);

# 6.주문정보
create table order_info (
	order_num int,
    order_time datetime,
	order_type char(6),
    customer_id int,
    primary key(order_num),
    foreign key(customer_id) references customer(customer_id)
);

# 7.주문한 메뉴
create table ordered_menu (
	menu_id int,
    order_num int,
    quantity int check (quantity > 0),
    primary key(menu_id, order_num),
    foreign key(menu_id) references menu(menu_id),
    foreign key(order_num) references order_info(order_num)
);

# 8.대기번호
create table waiting_info (
	waiting_num int,
    corner_id int,
    order_num int,
    primary key(waiting_num, corner_id),
    foreign key(corner_id) references corner(corner_id),
    foreign key(order_num) references order_info(order_num)
);

# 9.리뷰
create table review (
	review_id int,
    menu_id int,
    review_descript tinytext,
    rate int,
    review_time datetime,
    customer_id int not null,
    recommendation int default 0,
    primary key(review_id),
    foreign key(menu_id) references menu(menu_id),
    foreign key(customer_id) references customer(customer_id)
);

