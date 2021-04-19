<?php

use Illuminate\Database\Migrations\Migration;
use Oxygen\Preferences\PreferencesManager;

class AddAdminLayout extends Migration {

    /**
     * Run the migrations.
     */
    public function up() {
        $preferences = app(PreferencesManager::class);

        $schema = $preferences->getSchema('appearance.admin');
        $schema->getRepository()->set('adminLayout', 'oxygen/ui-base::layout.main');
        $schema->storeRepository();
    }

    /**
     * Reverse the migrations.
     */
    public function down() {
        $preferences = app(PreferencesManager::class);

        $schema = $preferences->getSchema('appearance.admin');
        $schema->getRepository()->set('adminLayout', null);
        $schema->storeRepository();
    }
}
