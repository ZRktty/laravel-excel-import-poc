# POC: import products with Laravel Excel

-  [x]  Create Laravel 11 project (Sail, MySQL,
- [x] Install Filament, create admin panel
- [x] Create User panel (add user, login, logout) with Filament)
- [x] Create Product model, migration
- [x] Create Brand model, migration
- [x] Add and config Category handler package (Rinvex)
- [x] Every Product has a Brand (foreign id reference)
- [x] A product can be in multiple categories (many to many) 
            - pivot table: category_product   
- [x] Import products from Excel file (1. install and configure LaravelExcel, simple file upload trough DevController /import route;)
- [x] Add queued import capability (2. add queue to import job db/horizon)
- [x] Test: import with large number 10K products (3. create test Excel file with 10K products), tested with 7830 products wihtout images and category imports
- [ ] Add category import
- [ ] Add image import: import images from URL (it should put into a seperate lower prio queue)
