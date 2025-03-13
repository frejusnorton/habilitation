<?php

namespace Database\Seeders;


use Carbon\Carbon;
use App\Models\Acl;
use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use App\Models\Service;
use App\Models\RoleMenu;
use App\Models\Direction;
use App\Models\Departement;
use App\Models\RolePageAction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Direction::truncate();
        $direction = Direction::create([
            'code' => 'DIR-001',
            'libelle' => "Direction des systemes d'informations",
            'statut' => 1
        ]);

        Service::truncate();
        $service = Service::create([
            'code' => 'SVC-001',
            'libelle' => 'Support Technique',
            'statut' => 1
        ]);

        Departement::truncate();
        $departement = Departement::create([
            'code' => 'DEP-001',
            'libelle' => 'Direction Générale',
            'statut' => 1
        ]);
        Menu::truncate();

        $menu1 = Menu::create([
            'titre' => 'Habilitation',
            'titreSecondaire' => 'Habilitation',
            'routeName' => '',
            'icone' => '<i class="bi bi-shield fs-2x"></i>',
            'hassubmenu' => true,
            'position' => 1,
            'statut' => 1,
        ]);
        //SOUS MENU HABILITATION
        $menu1A = Menu::create([
            'titre' => 'Mes demandes',
            'titreSecondaire' => 'Mes demandes',
            'routeName' => 'app_habilitation_index',
            'icone' => '<i class="bi bi-list-check "></i>',
            'parent' => $menu1->id,
            'isSubMenu' => true,
            'position' => 1,
            'statut' => 1,
        ]);

        $menu3 = Menu::create([
            'titre' => 'Organisation',
            'titreSecondaire' => 'Organisation',
            'routeName' => '',
            'icone' => '<i class="bi bi-sliders fs-2x"></i>',
            'hassubmenu' => true,
            'position' => 2,
            'statut' => 1,
        ]);

        //SOUS MENU ORGANISATION
        $menu3A = Menu::create([
            'titre' => 'Listes des services',
            'titreSecondaire' => 'Listes des services',
            'routeName' => 'app_service_index',
            'icone' => '<i class="bi bi-list-check fs-2x"></i>',
            'parent' => $menu3->id,
            'isSubMenu' => true,
            'position' => 1,
            'statut' => 1,
        ]);

        $menu1B = Menu::create([
            'titre' => 'Listes des agences',
            'titreSecondaire' => 'Listes des agences',
            'routeName' => 'app_agence_index',
            'icone' => '<i class="bi bi-list-check fs-2x"></i>',
            'parent' => $menu3->id,
            'isSubMenu' => true,
            'position' => 2,
            'statut' => 1,
        ]);
        $menu1C = Menu::create([
            'titre' => 'Listes des departements',
            'titreSecondaire' => 'Listes des departements',
            'routeName' => 'app_departement_index',
            'icone' => '<i class="bi bi-list-check fs-2x"></i>',
            'parent' => $menu3->id,
            'isSubMenu' => true,
            'position' => 3,
            'statut' => 1,
        ]);
        $menu1D = Menu::create([
            'titre' => 'Listes des directions',
            'titreSecondaire' => 'Listes des directions',
            'routeName' => 'app_direction_index',
            'icone' => '<i class="bi bi-list-check fs-2x"></i>',
            'parent' => $menu3->id,
            'isSubMenu' => true,
            'position' => 4,
            'statut' => 1,
        ]);

        $menu2 = Menu::create([
            'titre' => 'Administration',
            'titreSecondaire' => 'Administration',
            'routeName' => '',
            'icone' => '<i class="bi bi-gear fs-2x "></i>',
            'hassubmenu' => true,
            'position' => 2,
            'statut' => 1,
        ]);
        //SOUS MENU ADMINISTRATION
        $menu2A = Menu::create([
            'titre' => 'Liste des roles',
            'titreSecondaire' => 'Liste des roles',
            'routeName' => 'app_role_index',
            'icone' => '<i class="bi bi-diagram-3 fs-2x"></i>',
            'parent' => $menu2->id,
            'isSubMenu' => true,
            'position' => 1,
            'statut' => 1,
        ]);
        $menu2B = Menu::create([
            'titre' => 'Liste des utilisateurs',
            'titreSecondaire' => 'Liste des utilisateurs',
            'routeName' => 'app_user_index',
            'icone' => '<i class="bi bi-users fs-2x"></i>',
            'parent' => $menu2->id,
            'isSubMenu' => true,
            'position' => 2,
            'statut' => 1
        ]);

        $menu2C = Menu::create([
            'titre' => 'Liste des applications',
            'titreSecondaire' => 'Liste des applications',
            'routeName' => 'app_application_index',
            'icone' => '<i class="bi bi-app fs-2x"></i>',
            'parent' => $menu2->id,
            'isSubMenu' => true,
            'position' => 3,
            'statut' => 1
        ]);

        $menu4 = Menu::create([
            'titre' => 'Configuration',
            'titreSecondaire' => 'Configuration',
            'routeName' => '',
            'icone' => '<i class="bi bi-sliders fs-2x"></i>',
            'hassubmenu' => true,
            'position' => 4,
            'statut' => 1,
        ]);
        $menu5 = Menu::create([
            'titre' => 'Aide',
            'titreSecondaire' => 'Aide',
            'routeName' => 'app_role_index',
            'icone' => '<i class="bi bi-info fs-2x"></i>',
            'isSubMenu' => false,
            'hassubmenu' => false,
            'position' => 5,
            'statut' => 1,
        ]);

        $menu8 = Menu::create([
            'titre' => 'Liste des menus',
            'titreSecondaire' => 'Configuration des menus',
            'routeName' => 'app_menu_index',
            'icone' => '<i class="bi  bi-menu-button-wide fs-2x"></i>',
            'parent' => $menu4->id,
            'isSubMenu' => true,
            'position' => 4,
            'statut' => 1
        ]);
        $menu10 = Menu::create([
            'titre' => 'Liste des logs',
            'titreSecondaire' => 'Liste des logs',
            'routeName' => 'app_activity_index',
            'icone' => '<i class="bi bi-clock-history"></i>',
            'parent' => $menu1->id,
            'isSubMenu' => true,
            'position' => 4,
            'statut' => 1
        ]);




        Acl::truncate();
        $acl1 = Acl::create([
            'identifiant' => 'can_add_role',
            'libelle' => 'Ajout d\'un role',
            'menu_id' => $menu1->id,
            'statut' => 1,
        ]);
        $acl2 = Acl::create([
            'identifiant' => 'can_see_all_role',
            'libelle' => 'peut voir tous les roles',
            'menu_id' => $menu1->id,
            'statut' => 1,
        ]);
        $acl3 = Acl::create([
            'identifiant' => 'can_see_role',
            'libelle' => 'peut voir le detail d\'un role',
            'menu_id' => $menu1->id,
            'statut' => 1,
        ]);

        $acl4 = Acl::create([

            'identifiant' => 'can_update_role',
            'libelle' => 'Peut modifier un role',
            'menu_id' => $menu1->id,
            'statut' => 1,
        ]);

        /**
         * Users
         */
        $acl5 = Acl::create([
            'identifiant' => 'can_add_user',
            'libelle' => 'Peut Ajouter un utilisateur',
            'menu_id' => $menu5->id,
            'statut' => 1,
        ]);

        $acl6 = Acl::create([

            'identifiant' => 'can_see_all_users',
            'libelle' => 'Peut voir les utilisateurs',
            'menu_id' => $menu5->id,
            'statut' => 1,
        ]);

        $acl7 = Acl::create([

            'identifiant' => 'can_see_user',
            'libelle' => 'Peut voir le detail d\'un utilisateur',
            'menu_id' => $menu5->id,
            'statut' => 1,
        ]);

        $acl8 = Acl::create([

            'identifiant' => 'can_update_user',
            'libelle' => 'Peut modifier un utilisateur',
            'menu_id' => $menu5->id,
            'statut' => 1,
        ]);

        $acl9 = Acl::create([

            'identifiant' => 'can_delete_user',
            'libelle' => 'Peut supprimer un utilisateur',
            'menu_id' => $menu5->id,
            'statut' => 1,
        ]);

        $acl10 = Acl::create([

            'identifiant' => 'can_validate_user',
            'libelle' => 'Peut valider un utilisateur',
            'menu_id' => $menu5->id,
            'statut' => 1,
        ]);

        $acl11 = Acl::create([

            'identifiant' => 'can_activate_user',
            'libelle' => 'Peut activer un utilisateur',
            'menu_id' => $menu5->id,
            'statut' => 1,
        ]);

        $acl12 = Acl::create([
            'identifiant' => 'can_desactivate_user',
            'libelle' => 'Peut desactiver un utilisateur',
            'menu_id' => $menu5->id,
            'statut' => 1,
        ]);

        Role::truncate();
        $role1 = Role::create([
            'role_name' => 'ALLTEST',
            'description' => 'ALLTEST',
            'statut' => 1,
        ]);


        RoleMenu::truncate();
        RoleMenu::insert(
            [
                [
                    'role_id' => $role1->id,
                    'menu_id' => $menu1->id,
                ],
                [

                    'role_id' => $role1->id,
                    'menu_id' => $menu1A->id,
                ],
                [

                    'role_id' => $role1->id,
                    'menu_id' => $menu2->id,
                ],
                [

                    'role_id' => $role1->id,
                    'menu_id' => $menu4->id,
                ],
                [

                    'role_id' => $role1->id,
                    'menu_id' => $menu5->id,
                ],

                [

                    'role_id' => $role1->id,
                    'menu_id' => $menu8->id,
                ],

                [
                    'role_id' => $role1->id,
                    'menu_id' => $menu10->id,
                ],
                [
                    'role_id' => $role1->id,
                    'menu_id' => $menu2A->id,
                ],
                [
                    'role_id' => $role1->id,
                    'menu_id' => $menu2B->id,
                ],
                [
                    'role_id' => $role1->id,
                    'menu_id' => $menu2C->id,
                ],
            ]

        );

        RolePageAction::truncate();
        RolePageAction::insert(
            [
                'role_id' => $role1->id,
                'acl' => $acl1->id,
            ],
            [
                'role_id' => $role1->id,
                'acl' => $acl2->id,
            ],
            [
                'role_id' => $role1->id,
                'acl' => $acl3->id,
            ],
            [
                'role_id' => $role1->id,
                'acl' => $acl4->id,
            ],
            [
                'role_id' => $role1->id,
                'acl' => $acl5->id,
            ],
            [
                'role_id' => $role1->id,
                'acl' => $acl6->id,
            ],
            [
                'role_id' => $role1->id,
                'acl' => $acl7->id,
            ],
            [
                'role_id' => $role1->id,
                'acl' => $acl8->id,
            ],
            [
                'role_id' => $role1->id,
                'acl' => $acl9->id,
            ],
            [
                'role_id' => $role1->id,
                'acl' => $acl10->id,
            ],
            [
                'role_id' => $role1->id,
                'acl' => $acl11->id,
            ],
            [
                'role_id' => $role1->id,
                'acl' => $acl12->id,
            ],
        );

        User::truncate();
        User::create(attributes: [
            'username' => '',
            'nom' => 'admin',
            'prenom' => 'admin',
            'email' => 'admin@orabank.net',
            'role' => $role1->id,
            'password' => Hash::make('P@ssw0rd'),
            'statut' => 1,
            'admin' => true,
            'service_id' =>  $service->id,
            'departement_id' =>  $departement->id,
            'direction_id' =>  $direction->id,
            'agence_id' => 99999,
            'initiated_at' => Carbon::now(),
            'autorized_at' => Carbon::now(),
        ]);

        User::create([
            'username' => 'f.aguessy',
            'nom' => 'AGUESSY',
            'prenom' => 'Fréjus',
            'email' => 'f.aguessy@orabank.net',
            'role' => $role1->id,
            'password' => Hash::make('P@ssw0rd'),
            'statut' => 1,
            'admin' => true,
            'service_id' =>  $service->id,
            'departement_id' =>  $departement->id,
            'direction_id' =>  $direction->id,
            'agence_id' => 99999,
            'initiated_at' => Carbon::now(),
            'autorized_at' => Carbon::now(),
        ]);
        User::create([
            'username' => 'n.kpossa',
            'nom' => 'KPOSSA',
            'prenom' => 'Nabil',
            'email' => 'n.kpossa@orabank.net',
            'role' => $role1->id,
            'password' => Hash::make('P@ssw0rd'),
            'statut' => 1,
            'admin' => true,
            'service_id' =>  $service->id,
            'departement_id' =>  $departement->id,
            'direction_id' =>  $direction->id,
            'agence_id' => 99999,
            'initiated_at' => Carbon::now(),
            'autorized_at' => Carbon::now(),
        ]);
    }
}
