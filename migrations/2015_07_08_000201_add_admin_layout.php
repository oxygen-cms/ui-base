<?php

use Illuminate\Database\Migrations\Migration;
use Oxygen\Preferences\PreferencesManager;

class AddAdminLayout extends Migration {

    /**
     * Run the migrations.
     *
     * @param \Oxygen\Preferences\PreferencesManager $preferences
     */
    public function up(PreferencesManager $preferences) {
        $schema = $preferences->getSchema('appearance.admin');
        $schema->getRepository()->set('adminLayout', 'oxygen/ui-base::layout.main');
        $schema->storeRepository();
    }

    /**
     * Reverse the migrations.
     *
     * @param \Oxygen\Preferences\PreferencesManager $preferences
     */
    public function down(PreferencesManager $preferences) {
        $schema = $preferences->getSchema('appearance.admin');
        $schema->getRepository()->set('adminLayout', null);
        $schema->storeRepository();
    }
}
