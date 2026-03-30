<?php

namespace Database\Seeders\DevLife;

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Database\Seeder;

class TranslationsSeeder extends Seeder
{
    public function run(): void
    {
        $common = [
            'Login',
            'Create account',
            'Dashboard',
            'Profile',
            'Tasks',
            'Done',
            'To Do',
            'In Progress',
            'Priority',
            'Save',
            'Logout',
            'App Settings',
            'Roles',
            'Permissions',
            'Languages',
            'Countries',
            'Active',
            'Default',
            'Save changes',
            'Search',
            'Name',
            'Key',
            'Description',
            'Add',
            'Edit',
            'Delete',
            'Cancel',
            'Update',
            'Theme',
            'Light',
            'Dark',
            'Task Manager',
            'Workspace',
            'Admin',
            'Account',
            'Board',
            'All',
            'Urgent',
            'High',
            'Normal',
            'Low',
            'Language',
            'Preferences',
        ];

        $this->seed('fr', array_merge($this->mapCommon($common, [
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
            'App Settings' => 'Paramètres de l’application',
            'Roles' => 'Rôles',
            'Permissions' => 'Autorisations',
            'Languages' => 'Langues',
            'Countries' => 'Pays',
            'Active' => 'Actif',
            'Default' => 'Par défaut',
            'Save changes' => 'Enregistrer les modifications',
            'Search' => 'Rechercher',
            'Name' => 'Nom',
            'Key' => 'Clé',
            'Description' => 'Description',
            'Add' => 'Ajouter',
            'Edit' => 'Modifier',
            'Delete' => 'Supprimer',
            'Cancel' => 'Annuler',
            'Update' => 'Mettre à jour',
            'Theme' => 'Thème',
            'Light' => 'Clair',
            'Dark' => 'Sombre',
            'Task Manager' => 'Gestionnaire de tâches',
            'Workspace' => 'Espace de travail',
            'Admin' => 'Admin',
            'Account' => 'Compte',
            'Board' => 'Tableau',
            'All' => 'Tout',
            'Urgent' => 'Urgent',
            'High' => 'Élevée',
            'Normal' => 'Normale',
            'Low' => 'Faible',
            'Language' => 'Langue',
            'Preferences' => 'Préférences',
        ])));

        $this->seed('es', array_merge($this->mapCommon($common, [
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
            'App Settings' => 'Configuración de la app',
            'Roles' => 'Roles',
            'Permissions' => 'Permisos',
            'Languages' => 'Idiomas',
            'Countries' => 'Países',
            'Active' => 'Activo',
            'Default' => 'Predeterminado',
            'Save changes' => 'Guardar cambios',
            'Search' => 'Buscar',
            'Name' => 'Nombre',
            'Key' => 'Clave',
            'Description' => 'Descripción',
            'Add' => 'Agregar',
            'Edit' => 'Editar',
            'Delete' => 'Eliminar',
            'Cancel' => 'Cancelar',
            'Update' => 'Actualizar',
            'Theme' => 'Tema',
            'Light' => 'Claro',
            'Dark' => 'Oscuro',
            'Task Manager' => 'Gestor de tareas',
            'Workspace' => 'Espacio de trabajo',
            'Admin' => 'Admin',
            'Account' => 'Cuenta',
            'Board' => 'Tablero',
            'All' => 'Todos',
            'Urgent' => 'Urgente',
            'High' => 'Alta',
            'Normal' => 'Normal',
            'Low' => 'Baja',
            'Language' => 'Idioma',
            'Preferences' => 'Preferencias',
        ])));

        $this->seed('ar', array_merge($this->mapCommon($common, [
            'Login' => 'تسجيل الدخول',
            'Create account' => 'إنشاء حساب',
            'Dashboard' => 'لوحة التحكم',
            'Profile' => 'الملف الشخصي',
            'Tasks' => 'المهام',
            'Done' => 'تم',
            'To Do' => 'للقيام',
            'In Progress' => 'قيد التنفيذ',
            'Priority' => 'الأولوية',
            'Save' => 'حفظ',
            'Logout' => 'تسجيل الخروج',
            'App Settings' => 'إعدادات التطبيق',
            'Roles' => 'الأدوار',
            'Permissions' => 'الصلاحيات',
            'Languages' => 'اللغات',
            'Countries' => 'الدول',
            'Active' => 'نشط',
            'Default' => 'افتراضي',
            'Save changes' => 'حفظ التغييرات',
            'Search' => 'بحث',
            'Name' => 'الاسم',
            'Key' => 'المفتاح',
            'Description' => 'الوصف',
            'Add' => 'إضافة',
            'Edit' => 'تعديل',
            'Delete' => 'حذف',
            'Cancel' => 'إلغاء',
            'Update' => 'تحديث',
            'Theme' => 'المظهر',
            'Light' => 'فاتح',
            'Dark' => 'داكن',
            'Task Manager' => 'مدير المهام',
            'Workspace' => 'مساحة العمل',
            'Admin' => 'الإدارة',
            'Account' => 'الحساب',
            'Board' => 'اللوحة',
            'All' => 'الكل',
            'Urgent' => 'عاجل',
            'High' => 'مرتفع',
            'Normal' => 'عادي',
            'Low' => 'منخفض',
            'Language' => 'اللغة',
            'Preferences' => 'التفضيلات',
        ])));

        $this->seed('hi', array_merge($this->mapCommon($common, [
            'Login' => 'लॉगिन',
            'Create account' => 'खाता बनाएँ',
            'Dashboard' => 'डैशबोर्ड',
            'Profile' => 'प्रोफ़ाइल',
            'Tasks' => 'कार्य',
            'Done' => 'पूर्ण',
            'To Do' => 'करना है',
            'In Progress' => 'प्रगति में',
            'Priority' => 'प्राथमिकता',
            'Save' => 'सेव',
            'Logout' => 'लॉगआउट',
            'App Settings' => 'ऐप सेटिंग्स',
            'Roles' => 'भूमिकाएँ',
            'Permissions' => 'अनुमतियाँ',
            'Languages' => 'भाषाएँ',
            'Countries' => 'देश',
            'Active' => 'सक्रिय',
            'Default' => 'डिफ़ॉल्ट',
            'Save changes' => 'परिवर्तन सेव करें',
            'Search' => 'खोजें',
            'Name' => 'नाम',
            'Key' => 'कुंजी',
            'Description' => 'विवरण',
            'Add' => 'जोड़ें',
            'Edit' => 'संपादित करें',
            'Delete' => 'हटाएँ',
            'Cancel' => 'रद्द करें',
            'Update' => 'अपडेट करें',
            'Theme' => 'थीम',
            'Light' => 'लाइट',
            'Dark' => 'डार्क',
            'Task Manager' => 'कार्य प्रबंधक',
            'Workspace' => 'वर्कस्पेस',
            'Admin' => 'एडमिन',
            'Account' => 'खाता',
            'Board' => 'बोर्ड',
            'All' => 'सभी',
            'Urgent' => 'अत्यावश्यक',
            'High' => 'उच्च',
            'Normal' => 'सामान्य',
            'Low' => 'कम',
            'Language' => 'भाषा',
            'Preferences' => 'पसंद',
        ])));
    }

    /**
     * @param  array<int, string>  $keys
     * @param  array<string, string>  $overrides
     * @return array<string, string>
     */
    private function mapCommon(array $keys, array $overrides): array
    {
        $base = [];
        foreach ($keys as $key) {
            $base[$key] = $key;
        }

        return array_replace($base, $overrides);
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
