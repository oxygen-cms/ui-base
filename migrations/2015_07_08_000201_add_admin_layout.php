<?php

use Illuminate\Database\Migrations\Migration;
use Oxygen\Preferences\PreferencesManager;

use App;

class AddAdminLayout extends Migration {

    /**
     * Run the migrations.
     */
    public function up() {
        $preferences = App::make(PreferencesManager::class);

        $schema = $preferences->getSchema('appearance.admin');
        $schema->getRepository()->set('adminLayout', 'oxygen/ui-base::layout.main');
        $schema->storeRepository();
    }

    /**
     * Reverse the migrations.
     */
    public function down() {
        $preferences = App::make(PreferencesManager::class);

        $schema = $preferences->getSchema('appearance.admin');
        $schema->getRepository()->set('adminLayout', null);
        $schema->storeRepository();
    }
}
