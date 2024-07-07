<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create permissions
        Permission::create(['name' => 'view-dashboard']);

        Permission::create(['name' => 'view-category']);
        Permission::create(['name' => 'add-category']);
        Permission::create(['name' => 'edit-category']);
        Permission::create(['name' => 'delete-category']);

        Permission::create(['name' => 'view-product']);
        Permission::create(['name' => 'add-product']);
        Permission::create(['name' => 'edit-product']);
        Permission::create(['name' => 'delete-product']);

        Permission::create(['name' => 'view-user']);
        Permission::create(['name' => 'add-user']);
        Permission::create(['name' => 'edit-user']);
        Permission::create(['name' => 'delete-user']);

        Permission::create(['name' => 'view-customer']);
        Permission::create(['name' => 'add-customer']);
        Permission::create(['name' => 'edit-customer']);
        Permission::create(['name' => 'delete-customer']);

        Permission::create(['name' => 'view-forecast']);

        Permission::create(['name' => 'view-order']);
        Permission::create(['name' => 'add-order']);
        Permission::create(['name' => 'edit-order']);
        Permission::create(['name' => 'delete-order']);

        Permission::create(['name' => 'view-employment']);
        Permission::create(['name' => 'add-employment']);
        Permission::create(['name' => 'edit-employment']);
        Permission::create(['name' => 'delete-employment']);

        Permission::create(['name' => 'view-employee']);
        Permission::create(['name' => 'add-employee']);
        Permission::create(['name' => 'edit-employee']);
        Permission::create(['name' => 'delete-employee']);

        Permission::create(['name' => 'view-pembelian-barang']);
        Permission::create(['name' => 'add-pembelian-barang']);
        Permission::create(['name' => 'edit-pembelian-barang']);
        Permission::create(['name' => 'delete-pembelian-barang']);

        Permission::create(['name' => 'view-supplier']);
        Permission::create(['name' => 'add-supplier']);
        Permission::create(['name' => 'edit-supplier']);
        Permission::create(['name' => 'delete-supplier']);

        Permission::create(['name' => 'view-manajemen-penjualan']);
        Permission::create(['name' => 'add-manajemen-penjualan']);
        Permission::create(['name' => 'edit-manajemen-penjualan']);
        Permission::create(['name' => 'delete-manajemen-penjualan']);

        Permission::create(['name' => 'view-salary-payment']);
        Permission::create(['name' => 'add-salary-payment']);
        Permission::create(['name' => 'edit-salary-payment']);
        Permission::create(['name' => 'delete-salary-payment']);

        Permission::create(['name' => 'view-debts']);
        Permission::create(['name' => 'add-debts']);
        Permission::create(['name' => 'edit-debts']);
        Permission::create(['name' => 'delete-debts']);

        Permission::create(['name' => 'view-receivables']);
        Permission::create(['name' => 'add-receivables']);
        Permission::create(['name' => 'edit-receivables']);
        Permission::create(['name' => 'delete-receivables']);

        Permission::create(['name' => 'view-sales']);
        Permission::create(['name' => 'add-sales']);
        Permission::create(['name' => 'edit-sales']);
        Permission::create(['name' => 'delete-sales']);

        Permission::create(['name' => 'view-income-statement']);
        Permission::create(['name' => 'add-income-statement']);
        Permission::create(['name' => 'edit-income-statement']);
        Permission::create(['name' => 'delete-income-statement']);

        Permission::create(['name' => 'view-cash-flow']);
        Permission::create(['name' => 'add-cash-flow']);
        Permission::create(['name' => 'edit-cash-flow']);
        Permission::create(['name' => 'delete-cash-flow']);

        Permission::create(['name' => 'view-expert-system-symptom']);
        Permission::create(['name' => 'add-expert-system-symptom']);
        Permission::create(['name' => 'edit-expert-system-symptom']);
        Permission::create(['name' => 'delete-expert-system-symptom']);

        Permission::create(['name' => 'view-expert-system-pestdisease']);
        Permission::create(['name' => 'add-expert-system-pestdisease']);
        Permission::create(['name' => 'edit-expert-system-pestdisease']);
        Permission::create(['name' => 'delete-expert-system-pestdisease']);

        Permission::create(['name' => 'view-expert-system-rulebase']);
        Permission::create(['name' => 'add-expert-system-rulebase']);
        Permission::create(['name' => 'edit-expert-system-rulebase']);
        Permission::create(['name' => 'delete-expert-system-rulebase']);

        Permission::create(['name' => 'view-cashier']);
        Permission::create(['name' => 'add-cashier']);
        Permission::create(['name' => 'edit-cashier']);
        Permission::create(['name' => 'delete-cashier']);

        Permission::create(['name' => 'view-blog']);
        Permission::create(['name' => 'add-blog']);
        Permission::create(['name' => 'edit-blog']);
        Permission::create(['name' => 'delete-blog']);

        Permission::create(['name' => 'view-subscription']);
        Permission::create(['name' => 'add-subscription']);
        Permission::create(['name' => 'edit-subscription']);
        Permission::create(['name' => 'delete-subscription']);

        Permission::create(['name' => 'view-chat']);
        Permission::create(['name' => 'add-chat']);
        Permission::create(['name' => 'edit-chat']);
        Permission::create(['name' => 'delete-chat']);

        Permission::create(['name' => 'view-settings']);
        Permission::create(['name' => 'add-settings']);
        Permission::create(['name' => 'edit-settings']);
        Permission::create(['name' => 'delete-settings']);

        Permission::create(['name' => 'view-profile']);
        Permission::create(['name' => 'add-profile']);
        Permission::create(['name' => 'edit-profile']);
        Permission::create(['name' => 'delete-profile']);

        Permission::create(['name' => 'view-user-management']);
        Permission::create(['name' => 'add-user-management']);
        Permission::create(['name' => 'edit-user-management']);
        Permission::create(['name' => 'delete-user-management']);

        Permission::create(['name' => 'view-role-permission']);
        Permission::create(['name' => 'add-role-permission']);
        Permission::create(['name' => 'edit-role-permission']);
        Permission::create(['name' => 'delete-role-permission']);

        Permission::create(['name' => 'view-slider']);
        Permission::create(['name' => 'add-slider']);
        Permission::create(['name' => 'edit-slider']);
        Permission::create(['name' => 'delete-slider']);

        Permission::create(['name' => 'view-banner']);
        Permission::create(['name' => 'add-banner']);
        Permission::create(['name' => 'edit-banner']);
        Permission::create(['name' => 'delete-banner']);

        Permission::create(['name' => 'view-term-condition']);
        Permission::create(['name' => 'add-term-condition']);
        Permission::create(['name' => 'edit-term-condition']);
        Permission::create(['name' => 'delete-term-condition']);

        Permission::create(['name' => 'view-privacy-policy']);
        Permission::create(['name' => 'add-privacy-policy']);
        Permission::create(['name' => 'edit-privacy-policy']);
        Permission::create(['name' => 'delete-privacy-policy']);

        Permission::create(['name' => 'view-faq']);
        Permission::create(['name' => 'add-faq']);
        Permission::create(['name' => 'edit-faq']);
        Permission::create(['name' => 'delete-faq']);

        Permission::create(['name' => 'view-about-us']);
        Permission::create(['name' => 'add-about-us']);
        Permission::create(['name' => 'edit-about-us']);
        Permission::create(['name' => 'delete-about-us']);

        Permission::create(['name' => 'view-contact-us']);
        Permission::create(['name' => 'add-contact-us']);
        Permission::create(['name' => 'edit-contact-us']);
        Permission::create(['name' => 'delete-contact-us']);



        //create roles and assign existing permissions
        $cashierRole = Role::create(['name' => 'cashier']);
        $cashierRole->givePermissionTo('view-dashboard');
        $cashierRole->givePermissionTo('view-cashier');
        $cashierRole->givePermissionTo('add-cashier');
        $cashierRole->givePermissionTo('edit-cashier');
        $cashierRole->givePermissionTo('delete-cashier');

        $employeeRole = Role::create(['name' => 'employee']);
        $employeeRole->givePermissionTo('view-dashboard');
        $employeeRole->givePermissionTo('view-product');
        $employeeRole->givePermissionTo('add-product');
        $employeeRole->givePermissionTo('edit-product');
        $employeeRole->givePermissionTo('delete-product');
        $employeeRole->givePermissionTo('view-order');
        $employeeRole->givePermissionTo('add-order');
        $employeeRole->givePermissionTo('edit-order');
        $employeeRole->givePermissionTo('delete-order');

        $superUserRole = Role::create(['name' => 'super-user']);

        $super = User::factory()->create([
            'name' => 'Super User',
            'email' => 'super@anecake.com',
            'password' => bcrypt('password')
        ]);
        $super->assignRole($superUserRole);

        $cashier = User::factory()->create([
            'name' => 'cashier',
            'email' => 'cashier@anecake.com',
            'password' => bcrypt('password')
        ]);
        $cashier->assignRole($cashierRole);
    }
}

