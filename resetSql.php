<?php
require 'connect.php';

// Drop TABLE "user"
$sql = "DROP TABLE user";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot delete TABLE "user": ' . mysql_error());
}

// Drop TABLE "employee"
$sql = "DROP TABLE employee";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot delete TABLE "employee": ' . mysql_error());
}

// Drop TABLE "product"
$sql = "DROP TABLE product";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot delete TABLE "product": ' . mysql_error());
}

// Drop TABLE "sales"
$sql = "DROP TABLE sales";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot delete TABLE "sales": ' . mysql_error());
}

// Drop TABLE "productCategory"
$sql = "DROP TABLE productCategory";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot delete TABLE "productCategory": ' . mysql_error());
}

// Drop TABLE "tableProfile"
$sql = "DROP TABLE customerProfile";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot delete TABLE "customerProfile": ' . mysql_error());
}

// Drop TABLE "customerCreditCard"
$sql = "DROP TABLE customerCreditCard";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot delete TABLE "customerCreditCard": ' . mysql_error());
}

// Drop TABLE "shoppingCart"
$sql = "DROP TABLE shoppingCart";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot delete TABLE "shoppingCart": ' . mysql_error());
}

// Drop TABLE "orderSummary"
$sql = "DROP TABLE orderSummary";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot delete TABLE "orderSummary": ' . mysql_error());
}

// Drop TABLE "orderDetail"
$sql = "DROP TABLE orderDetail";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot delete TABLE "orderDetail": ' . mysql_error());
}

// Drop TABLE "ci_sessions"
$sql = "DROP TABLE ci_sessions";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot delete TABLE "ci_sessions": ' . mysql_error());
}
echo 'All previous TABLES are deleted successfully<br>';






// Create TABLE "user"
$sql = "CREATE TABLE user(" .
    "userIndex INT NOT NULL AUTO_INCREMENT, " .
    "userID VARCHAR(15) NOT NULL," .
    "userType VARCHAR(20) NOT NULL, " .
    "userName VARCHAR(20) NOT NULL, " .
    "passWord VARCHAR(100) NOT NULL," .
    "PRIMARY KEY (userIndex));";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot create TABLE "user": ' . mysql_error());
}

// Create TABLE "employee"
$sql = "CREATE TABLE employee(" .
    "employeeIndex INT NOT NULL AUTO_INCREMENT, " .
    "userID VARCHAR(5) NOT NULL," .
    "userType VARCHAR(20) NOT NULL, " .
    "employeeFirstName VARCHAR(10) NOT NULL, " .
    "employeeLastName VARCHAR(10) NOT NULL, " .
    "employeeGender VARCHAR(10) NOT NULL, " .
    "employeeAge INT NOT NULL, " .
    "employeeSalary INT NOT NULL, " .
    "PRIMARY KEY (employeeIndex));";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot create TABLE "employee": ' . mysql_error());
}

// Create TABLE "product"  --> add purchasePrice, sellQuantity, profit
$sql = "CREATE TABLE product(" .
    "productIndex INT NOT NULL AUTO_INCREMENT, " .
    "productID VARCHAR(10) NOT NULL," .
    "productName VARCHAR(20) NOT NULL, " .
    "productOriginalPrice FLOAT NOT NULL, " .
    "salesType BOOLEAN NOT NULL, " .
    "productCategory VARCHAR(20) NOT NULL, " .
    "productQuantity INT NOT NULL, " .
    "productDescription VARCHAR(500) NOT NULL, " .
    "productImage VARCHAR(500) NOT NULL, " .
    "purchasePrice FLOAT NOT NULL, " .
    "sellQuantity INT NOT NULL, " .
    "profit FLOAT NOT NULL, " .
    "PRIMARY KEY (productIndex));";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot create TABLE "product": ' . mysql_error());
}

// Create TABLE "sales"
$sql = "CREATE TABLE sales(" .
    "salesIndex INT NOT NULL AUTO_INCREMENT, " .
    "productID VARCHAR(10) NOT NULL," .
    "productName VARCHAR(20) NOT NULL, " .
    "productOriginalPrice INT NOT NULL, " .
    "salesDiscount FLOAT NOT NULL, " .
    "salesPrice FLOAT NOT NULL," .
    "salesStartDate DATE NOT NULL," .
    "salesEndDate DATE NOT NULL," .
    "PRIMARY KEY (salesIndex));";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot create TABLE "sales": ' . mysql_error());
}

// Create TABLE "productCategory"
$sql = "CREATE TABLE productCategory(" .
    "categoryIndex INT NOT NULL AUTO_INCREMENT," .
    "categoryName VARCHAR(20) NOT NULL," .
    "categoryImage VARCHAR(500) NOT NULL," .
    "PRIMARY KEY (categoryIndex));";
$res = mysql_query($sql, $con);
if (!$res) {
    die ('Cannot create TABLE "productCategory": ' . mysql_error());
}

// Create TABLE "customerProfile"
$sql = "CREATE TABLE customerProfile(" .
    "userID VARCHAR(15) NOT NULL," .
    "firstName VARCHAR(10) NOT NULL," .
    "lastName VARCHAR(10) NOT NULL," .
    "gender VARCHAR(10) NOT NULL," .
    "addressLine1 VARCHAR(40) NOT NULL," .
    "addressLine2 VARCHAR(40) NOT NULL," .
    "city VARCHAR(20) NOT NULL," .
    "state VARCHAR(5) NOT NULL," .
    "zipCode VARCHAR(5) NOT NULL," .
    "phone VARCHAR(10) NOT NULL," .
    "PRIMARY KEY (userID));";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot create TABLE "customerProfile": ' . mysql_error());
}

// Create TABLE "customerCreditCard"
$sql = "CREATE TABLE customerCreditCard(" .
    "userID VARCHAR(15) NOT NULL," .
    "cardType VARCHAR(10) NOT NULL," .
    "cardNumber VARCHAR(16) NOT NULL," .
    "expirationMonth VARCHAR(2) NOT NULL," .
    "expirationYear VARCHAR(4) NOT NULL," .
    "cvv VARCHAR(3) NOT NULL," .
    "PRIMARY KEY (userID));";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot create TABLE "customerCreditCard": ' . mysql_error());
}

// Create TABLE "shoppingCart"
$sql = "CREATE TABLE shoppingCart(" .
    "userID VARCHAR(15) NOT NULL," .
    "productID VARCHAR(4) NOT NULL," .
    "quantity INT NOT NULL," .
    "CONSTRAINT userCartItem PRIMARY KEY (userID, productID));";
$res = mysql_query($sql, $con);
if (!$res) {
    die ('Cannot create TABLE "shoppingCart"' . mysql_error());
}

// Create TABLE "orderSummary"
$sql = "CREATE TABLE orderSummary(" .
    "orderIndex INT NOT NULL AUTO_INCREMENT," .
    "orderID VARCHAR(11) NOT NULL," .
    "userID VARCHAR(15) NOT NULL," .
    "orderDate DATE NOT NULL," .
    "total FLOAT NOT NULL," .
    "shippingName VARCHAR(30) NOT NULL," .
    "shippingAddress VARCHAR(500) NOT NULL, " .
    "shippingPhone VARCHAR(10) NOT NULL, " .
    "PRIMARY KEY (orderIndex));";
$res = mysql_query($sql, $con);
if (!$res) {
    die ('Cannot create TABLE "orderSummary"' . mysql_error());
}

// Create TABLE "orderDetail"
$sql = "CREATE TABLE orderDetail(" .
    "orderID VARCHAR(11) NOT NULL," .
    "productID VARCHAR(4) NOT NULL," .
    "price FLOAT NOT NULL," .
    "purchasePrice FLOAT NOT NULL," .
    "quantity INT NOT NULL," .
    "CONSTRAINT orderID_productID PRIMARY KEY (orderID, productID));";
$res = mysql_query($sql, $con);
if (!$res) {
    die ('Cannot create TABLE "orderDetail"' . mysql_error());
}

$sql = "CREATE TABLE ci_sessions(" .
        "id VARCHAR(40) NOT NULL, " .
        "ip_address VARCHAR(45) NOT NULL, " .
        "timestamp INT(10) unsigned DEFAULT 0 NOT NULL, " .
        "data blob NOT NULL, " .
        "PRIMARY KEY (id), " .
        "KEY ci_sessions_timestamp (timestamp));";
$res = mysql_query($sql, $con);
if (!$res) {
    die ('Cannot create TABLE "ci_sessions"' . mysql_error());
}

echo 'All new TABLES are created successfully<br>';






// Enter data into TABLE "user"
$sql = "INSERT INTO user".
    "(userID, userType, userName, passWord) ".
    "VALUES ".
    "('C0701123001', 'customer', 'taoxie@usc.edu', MD5('taoxie'))," .
    "('C0701123002', 'customer', 'xie0221@126.com', MD5('taoxie'))," .
    "('M001', 'manager', 'tao', MD5('tao'))," .
    "('M002', 'manager', 'john', MD5('john'))," .
    "('A001', 'administrator', 'rose', MD5('rose'))," .
    "('A002', 'administrator', 'papa', MD5('papa'))," .
    "('A003', 'administrator', 'mike', MD5('mike'))," .
    "('A004', 'administrator', 'jack', MD5('jack'))," .
    "('S001', 'salesManager', 'lee', MD5('lee'))," .
    "('S002', 'salesManager', 'joe', MD5('joe'))," .
    "('S003', 'salesManager', 'alice', MD5('alice'))," .
    "('S004', 'salesManager', 'michael', MD5('michael'))," .
    "('S005', 'salesManager', 'peter', MD5('peter'))," .
    "('S006', 'salesManager', 'christ', MD5('christ'))," .
    "('S007', 'salesManager', 'carter', MD5('carter'))," .
    "('S008', 'salesManager', 'bruce', MD5('bruce'))," .
    "('S009', 'salesManager', 'kevin', MD5('kevin'));";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot enter data into TABLE "user": ' . mysql_error());
}


// Enter data into TABLE "employee"
$sql = "INSERT INTO employee".
    "(userID, userType, employeeFirstName, employeeLastName, employeeGender, employeeAge, employeeSalary) ".
    "VALUES ".
    "('M001', 'manager', 'Tao', 'Xie', 'Male', '26', '100000')," .
    "('M002', 'manager', 'John', 'Smith', 'Male', '30', '90000')," .
    "('A001', 'administrator', 'Rose', 'Swift', 'Female', '25', '85000')," .
    "('A002', 'administrator', 'Papa', 'Jones', 'Male', '24', '83000')," .
    "('A003', 'administrator', 'Mike', 'Adams', 'Male', '25', '87000')," .
    "('A004', 'administrator', 'Jack', 'Wills', 'Male', '23', '81000')," .
    "('S001', 'salesManager', 'Lee', 'Green', 'Female', '23', '68000')," .
    "('S002', 'salesManager', 'Joe', 'Blake', 'Male', '22', '69000')," .
    "('S003', 'salesManager', 'Alice', 'White', 'Female', '21', '65000')," .
    "('S004', 'salesManager', 'Michael', 'Nelson', 'Male', '24', '60000')," .
    "('S005', 'salesManager', 'Peter', 'Parker', 'Male', '22', '59000')," .
    "('S006', 'salesManager', 'Christ', 'Evans', 'Female', '23', '70000')," .
    "('S007', 'salesManager', 'Carter', 'Collins', 'Male', '20', '55000')," .
    "('S008', 'salesManager', 'Bruce', 'Morris', 'Male', '23', '58000')," .
    "('S009', 'salesManager', 'Kevin', 'Bell', 'Female', '25', '55000');";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot enter data into TABLE "employee": ' . mysql_error());
}

// Enter data into TABLE "product"
$sql = "INSERT INTO product".
    "(productID, productName, productOriginalPrice, salesType, productCategory, productQuantity, productDescription, productImage, purchasePrice, sellQuantity, profit) ".
    "VALUES ".
    "('W001', 'Flute', 5000, 0, 'Woodwind', 24, 'After 20 years of continuous development, BETTERBUY has succeeded in creating a new, innovative lineup of Handmade flutes. Designed in consultation with András Adorján, international soloist, chamber musician, recording artist and professor of flute at the Munich University of Music and Performing Arts, the new BETTERBUY Handmade flute lineup allows performers to play with a wider range of expression and with the freedom to create their own unique tonal colors.', 'picture/sql_flute.jpg', 3000, 0, 0)," .
    "('W002', 'Piccolo', 7000, 1, 'Woodwind', 10, 'With its easy playability, accurate intonation, and characteristic piccolo sound, the YPC-32 is very popular with students as well as doublers. The body is made of sturdy, maintenance-free ABS resin for a sound similar to that of natural wood.', 'picture/sql_piccolo.jpg', 4200, 0, 0)," .
    "('W003', 'Oboe', 10000, 1, 'Woodwind', 10, 'BETTERBUY oboes achieve a clear sound quality and superb intonation by dramatically improving the precision and stability of the bore. Also to cope with various durability issues inherent in wooden wind instruments, Duet+ models employ innovative techniques to form a protective layer next to the air column. The combination of precious wood and state-of -the-art resin is not simply a Duet of tradition and technology - it is a Plus advantage indeed!', 'picture/sql_oboe.jpg', 6000, 0, 0)," .
    "('W004', 'Bassoon', 10000, 0, 'Woodwind', 10, 'BETTERBUY Custom bassoons, which are considered the finest bassoons currently being produced, can be heard in some of the world’s greatest orchestras. They deliver a full rich sound which allows control of the most subtle tone shadings in delicate passages, while letting you open the sound up beyond traditional limits. With redesigned tonehole shapes and positions, and ergonomic finger-friendly key shapes, they also feature extremely accurate intonation and a comfortable playability.', 'picture/sql_bassoon.jpg', 6000, 0, 0)," .
    "('W005', 'Sax', 5000, 0, 'Woodwind', 30, 'BETTERBUY offers a complete line of saxophones to suit every level of player from the beginning band student to the seasoned pro. Through the BETTERBUY ideology of vertical integration, the highest level Custom saxophone models are designed first, and elements of those models are carried down into the professional, intermediate, and even standard level saxophones. ', 'picture/sql_sax.jpg', 3000, 0, 0)," .
    "('W006', 'Clarinet', 5000, 0, 'Woodwind', 26, 'Precisely balanced and light to touch, BETTERBUY clarinets permit you to effortlessly create the tonal colors you desire - to forget about the technical aspects of your performance and concentrate on pure musicality.', 'picture/sql_clarinet.jpg', 3000, 0, 0)," .
    "('B001', 'Horn', 8000, 1, 'Brass', 10, 'The handmade 667V delivers a rich expressive tone with superb projection and flexibility. Its patented dual plane valve permits a unique tubing configuration for smooth transitions between Bb and F horns. The long leadpipe delivers remarkably accurate intonation, while the hollow valve rotors provide quick, free response.', 'picture/sql_horn.jpg', 4800, 0, 0)," .
    "('B002', 'Trumpet', 4000, 0, 'Brass', 20, 'Over the 20+ year history of the series, Xeno trumpets have continued to evolve with the artists who play them. In 2014, drawing from the knowledge and innovative concepts learned through the development of the Artist Model Chicago C trumpet, the entire Xeno Bb series was redesigned to attain the ultimate goal of ideas musical expression. ', 'picture/sql_trumpet.jpg', 2400, 0, 0)," .
    "('B003', 'Trombone', 4000, 1, 'Brass', 23, 'BETTERBUY Professional model trombones have long been popular thanks to their quick and agile response, highly accurate intonation, and rich warm tone. The new Pro series have kept all these fine qualities, while adding some design features from our top of the line Xeno trombones. Their broad sound has a well defined tonal core for excellent projection in all registers at any dynamics. ', 'picture/sql_trombone.jpg', 2400, 0, 0)," .
    "('B004', 'Tuba', 6000, 0, 'Brass', 10, 'The YBB-201 is an excellent alternative when budget is a strong consideration. It offers a large pro-sized bell and features a rich strong sound. It is easy to play and has accurate intonation.', 'picture/sql_tuba.jpg', 3600, 0, 0)," .
    "('P001', 'Snare Drum', 2000, 1, 'Percussion', 19, 'Short Hi-carbon steel 20 strands (SN1420CP). *Snare Plate (Pat. Pend.) BETTERBUY snare plates offer superior snare to head contact due to the slight bend in their design. When the string is drawn tight, the edge of the patented snare plate is pulled upward putting the snare in full contact with the head. Snare plates in the CP series are made using a special bonding agent between the plate and the coil that provides greater durability and finer response compared to previous designs.', 'picture/sql_snaredrum.jpg', 1200, 0, 0)," .
    "('P002', 'Cymbals', 2500, 0, 'Percussion', 15, 'Specially designed in close association with the world top drum corps specialists. Their warm, shimmering sound projects clearly into every corner of a stadium, with the ability for emphatic zing effects and a smooth, bright blend of overtones over a wide sonic spectrum. Brilliant Finish top, Traditional Finish bottom.', 'picture/sql_cymbals.jpg', 1500, 0, 0)," .
    "('P003', 'Bass Drum', 4000, 0, 'Percussion', 5, 'The new BS-9036 stand features a Heck Rack style locking mechanism with an improved rotational mechanism allowing the drum to lock into one playing position. This new system enables the drum to have a firm grasp at any angle. BS-9036 bass drum stand and CBC-836 bass drum cover included. CBW-836 bass drum wrap sold separately.', 'picture/sql_bassdrum.jpg', 2400, 0, 0)," .
    "('K001', 'Piano', 10000, 1, 'Keyboard', 10, 'BETTERBUY b Series features pianos in a range of heights, widths, and depths. The b1 and b2 boast slender profiles, making them ideal for small spaces. With its larger dimensions and heavier construction, the b3 upright requires a little more room but brings a rich, far-reaching sound.', 'picture/sql_piano.jpg', 6000, 0, 0)," .
    "('S001', 'Harp', 20000, 0, 'String', 10, 'Available in cherry or walnut (other woods by request), this lap harp has a beautiful mellow tone. It has a graceful shape to complement its excellent sound. Its 3 1/2 octave range from E below Middle C will provide even the advanced player with sufficient range for a broad selection of music. (Nylon stringing, 8 lbs., 32 x 22) Available in Cherry, Walnut, or Maple.', 'picture/sql_harp.jpg', 12000, 0, 0)," .
    "('S002', 'Violin', 4000, 0, 'String', 30, 'This entry-level violin provides beginners with an instrument that plays with a satisfying tone, while offering outstanding durability. Each instrument is handcrafted utilizing the same traditional methods that are used for high-end violins. The V3SKA comes complete with case, bow and rosin, so you have everything you need to play right away.', 'picture/sql_violin.jpg', 2400, 0, 0)," .
    "('S003', 'Cello', 5000, 1, 'String', 30, 'This entry-level cello provides beginners with an instrument that plays with a satisfying tone, while offering outstanding durability. Each instrument is crafted using traditional methods, with extra attention paid to the cello’s attractive look and comfortable feel. The VC3S comes complete with padded bag, bow and rosin, so you have everything you need to play right away.', 'picture/sql_cello.jpg', 3000, 0, 0);";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot enter data into TABLE "product": ' . mysql_error());
}

// Enter data into TABLE "sales"
$sql = "INSERT INTO sales".
    "(productID, productName, productOriginalPrice, salesDiscount, salesPrice, salesStartDate, salesEndDate) ".
    "VALUES ".
    "('W002', 'Piccolo', '7000', 0.9, 6300, '2015-07-01', '2017-07-25')," .
    "('W003', 'Oboe', '10000', 0.95, 9500, '2015-07-01', '2017-07-25')," .
    "('B001', 'Horn', '8000', 0.8, 6400, '2015-07-01', '2017-07-25')," .
    "('B003', 'Trombone', '4000', 0.85, 3400, '2015-07-01', '2017-07-25')," .
    "('P001', 'Snare Drum', '2000', 0.95, 1900, '2015-07-01', '2017-07-25')," .
    "('K001', 'Piano', '10000', 0.7, 7000, '2015-07-01', '2017-07-25')," .
    "('S003', 'Cello', '5000', 0.8, 4000, '2015-07-01', '2017-07-25');";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot enter data into TABLE "product": ' . mysql_error());
}

// Enter data into TABLE "productCategory"
$sql = "INSERT INTO productCategory" .
    "(categoryName, categoryImage) " .
    "VALUE" .
    "('Woodwind', 'picture/category_woodwind.jpg')," .
    "('Brass', 'picture/category_brass.jpg')," .
    "('Percussion', 'picture/category_percussion.jpg')," .
    "('Keyboard', 'picture/category_keyboard.jpg')," .
    "('String', 'picture/category_string.jpg');";
$res = mysql_query($sql, $con);
if (!$res) {
    die ('Cannot enter data into TABLE "productCategory": ' . mysql_error());
}

// Enter data into TABLE "customerProfile"
$sql = "INSERT INTO customerProfile".
    "(userID, firstName, lastName, gender, addressLine1, addressLine2, city, state, zipCode, phone) " .
    "VALUES ".
    "('C0701123001', 'Tao', 'Xie', 'Male', '2632 Ellendale Pl', 'Apt 311', 'Los Angeles', 'CA', 90007, 2134007759)," .
    "('C0701123002', 'Rose', 'Bay', 'Female', '2632 Ellendale Pl', 'Apt 312', 'Los Angeles', 'CA', 90007, 2134007760);";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot enter data into TABLE "customerProfile": ' . mysql_error());
}

// Enter data into TABLE "customerCreditCard"
$sql = "INSERT INTO customerCreditCard".
    "(userID, cardType, cardNumber, expirationMonth, expirationYear, cvv) " .
    "VALUES ".
    "('C0701123001', 'VISA', '1122334455667788', '01', '2019', '111')," .
    "('C0701123002', 'Master Card', '1122334455667788', '02', '2020', '222');";
$res = mysql_query($sql, $con);
if(!$res) {
    die ('Cannot enter data into TABLE "customerCreditCard": ' . mysql_error());
}
echo 'All data are entered successfully<br>';

mysql_close($con);
?>