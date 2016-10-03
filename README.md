#BETTERBUY

###Author: Tao Xie (USC ID: 5951684215)
###Date: 2015/07/09

###Customer-side: 
http://cs-server.usc.edu:4215/HW3/homeBETTERBUY.php
username and password:
taoxie@usc.edu / taoxie
xie0221@126.com / taoxie

###Company-side: 
http://cs-server.usc.edu:4215/HW3/login.php
username and password:
manager: tao / tao
administrator: rose / rose
sales manager: kevin / kevin

NOTE: I test my page on Chrome, and the page is perfectly displayed on 13-inch screen.

##1. Overview
My company’s customer-side website is about selling musical instruments, and it has a good name: BETTERBUY, the slogan is “no best, only better”. There are 5 kinds of instruments we sell: woodwind, brass, string, keyboard and percussion, every category has at least one special sales product.
When you open the homepage, you can see 6 big pictures named: woodwind, brass, string, keyboard, percussion and special sales, which are 5 product categories and all special sales. Without login, you can also review all product, but you can only save your shopping cart and place orders by setting up an account and logging in. By hitting these 6 big pictures, you can enter every product category. In each category’s page, you can see the normal products and special sales products. Special sales products are highlighted by using in-line mark and discount mark to attract customer to buy it. By hitting the product’s picture, you will enter this product’s introduction page and see the product detail including name, price, discount, description, etc. After login, you can add product into your shopping cart and place order. When you add some product into your shopping cart, some other product will be recommended to you, because other customers also buy those products together in the past. After placing an order, the order summary will come up, you can review all your history orders. 
On the company-side website, you can use sales manager’s account to login to add, delete, modify any products, or even add a new category. Every change will be displayed immediately on the company-side website.
I compose a 'resetSql.php' to reset my database, that is easy to set all data. If you want to reset my database, just refresh that page. All database information can be checked in this file.

##2. Database Introduction
There is one database called “betterbuy” to store all customer, employee and product information. In this database, there are 10 tables: user, employee, product, sales, customerProfile, customerCreditCard, shoppingCart, orderSummary, orderDetail, productCategory.
TABLE user: only contains userID, user type, username and password. Each time you log in the website, this table is to be visited to verify user’s authority.
TABLE employee: contains all employees’ personal information which are described in the writeup file of homework2.
TABLE product: contains product information, which includes productID, productName, productImage, category, salesType, stock, quantity, price and so on. When sales manager adds, deletes, modifies any product’s information, this table is to be changed. When one product is sold out, this product cannot be deleted from database, but its value of stock is 0, and it cannot be displayed on the website, and other customer cannot buy it.
TABLE sales: if salesType in TABLE product is 1, that product is a special sales and is stored in this table. This table contains productID, discount, startDate, endDate. If today is not between start date and end date, which means that product is not in the date range of special sales, and it is a normal product, and it cannot be displayed in the page of special sales.
TABLE productCategory: contains categoryName and its image. 
TABLE customerProfile: contains customer’s information which includes userID, shipping information, phone number, and so on. When order is placed, this information will be retrieved from this table. Customer have authority to change all of personal information.
TABLE customerCredit: contains customer’s credit card information which includes cardType, cardNumber, cvv and expiration month and year.
TABLE shoppingCart: contains productID, userID and quantity. This table is a temporary table for restoring the product customers save but have not buy yet. When order is placed, related product information will be deleted from this table.
TABLE orderSummary: contains orderDate, userID, total and shipping information at that time. Because people could change their address, phone number, even name, these history information need to be stored into this table for shipping and review later.
TABLE orderDetail: contains orderID, productID, price, quantity, every orderID could have multiple rows because customers could buy multiple products each time.

##3. Customer Dashboard Design
On the top-right of page, you can see an icon named “sign in/up”, you can sign up a new account or log in your exist account. All information you type in is to be validated by Javascript. If you type in invalid information, you have to correct it in order to sign up successfully. After signing up, you can edit and update your personal information as well, and all information will be verified also.
After Logging in, the icon I mentioned above is turned to be your first name, and when you put your mouse over this icon, a dashboard pop up to let you edit profile, review history orders and log out. I will introduce history order reviewing function in the following section. 
By hitting logout button, the login session will be destroyed to protect your account. 5 minutes is to be set as inactive time limit, that means this account will be log out automatically when you do nothing in the 5 minutes.

##4. Shopping Cart Design
After logging in, if you want to buy something, you can add it into your shopping cart, each time you can add only one kind of product, but the quantity can be more than one as you want. Every product has a stock, the quantity each product you buy must less than this stock, and Javascript validation will remind and stop you when you add too many products. When customer A buy 1 product, the stock will reduce one, when the stock turn to 0, this product cannot be bought and cannot be displayed on the page.
You can buy whatever you want in a single order, so the shopping cart will help you save these products and let you edit the quantity or even delete them. When you change anything in the shopping cart, the subtotal and total will change dynamically to help you evaluate this order. I compose a 'resetSql.php' to reset my database, that is easy to set all data. If you want to reset my database, just refresh that page. All database information can be checked in this file. Note that you need to hit the “save your cart” button when you leave that page, otherwise changes cannot be saved into database. 
Each time you put a product into your shopping cart, some other products are recommended on the bottom of page, because these products are bought together by other people when they buy this product. You can also hit the picture of recommended product to buy them or just ignore them.
After you place an order, your shopping cart will be emptied and all your current shipping information is stored into database. You can review your history orders by hitting the “review orders” button in the user dashboard. On every order frame, there is a order ID, you can review the order detail by clicking that order ID.

##5. Menu and Searching Design
On the left-top of page, there is an icon called “product”. When you put your mouse over this icon, all product category and special sales assembly will come out, and you can choose what you want to review them.
Beside the “product” menu, there is a keyword search field, you can input some keyword to search items. For example, you type in “pi”, the piccolo and piano will come up. To make the searching more concise, the keyword is just match the product name.

##6. UE and UI Design
I spend almost half of time to choose font, picture, icon and design every detail to improve user experience and make my page beautiful. 
