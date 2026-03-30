<?php

namespace Database\Seeders\DevLife;

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Database\Seeder;

class TranslationsSeeder extends Seeder
{
    public function run(): void
    {
        $this->seed('fr', [
            'Login' => 'Connexion',
            'Create account' => 'Créer un compte',
            'Dashboard' => 'Tableau de bord',
            'Profile' => 'Profil',
            'Tasks' => 'Tâches',
            'Done' => 'Terminé',
            'To Do' => 'À faire',
            'In Progress' => 'En cours',
            'Priority' => 'Priorité',
            'Save' => 'Enregistrer',
            'Logout' => 'Déconnexion',
        ]);

        $this->seed('es', [
            'Login' => 'Iniciar sesión',
            'Create account' => 'Crear cuenta',
            'Dashboard' => 'Panel',
            'Profile' => 'Perfil',
            'Tasks' => 'Tareas',
            'Done' => 'Hecho',
            'To Do' => 'Por hacer',
            'In Progress' => 'En progreso',
            'Priority' => 'Prioridad',
            'Save' => 'Guardar',
            'Logout' => 'Cerrar sesión',
        ]);
    }

    /**
     * @param  array<string, string>  $lines
     */
    private function seed(string $locale, array $lines): void
    {
        $languageId = Language::query()->where('code', $locale)->value('id');
        if (!$languageId) {
            return;
        }

        foreach ($lines as $key => $value) {
            Translation::query()->updateOrCreate(
                ['language_id' => $languageId, 'key' => $key],
                ['value' => $value],
            );
        }
    }
}

