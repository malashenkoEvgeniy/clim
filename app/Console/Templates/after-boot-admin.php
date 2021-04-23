    /**
     * Register widgets and menu for admin panel
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {{PublicSettings}
        // Register role scopes
        CustomRoles::add('{ModuleAlias}', '{ModuleAlias}::general.permission-name');
    }
