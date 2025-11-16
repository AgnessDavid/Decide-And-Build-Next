<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;


use Illuminate\Database\Eloquent\Casts\Attribute;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'last_login_at',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }


    public static function getAvailableRoles(): array
    {
        return [
            'gestionnaire' => 'Gestionnaire',
            'admin' => 'Administrateur',
            'superadmin' => 'Super Administrateur',
        ];
    }

    public function hasRole(string|array $role): bool
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }

        return $this->role === $role;
    }



    /**
     * Vérifier si l'utilisateur peut gérer les utilisateurs
     */
    public function canManageUsers(): bool
    {
        return $this->hasRole(['admin', 'superadmin']);
    }

    /**
     * Vérifier si l'utilisateur peut créer des admins
     */
    public function canCreateAdmins(): bool
    {
        return $this->hasRole('superadmin');
    }

    /**
     * Vérifier si l'utilisateur peut accéder aux rapports
     */
    public function canViewReports(): bool
    {
        return $this->hasRole(['admin', 'superadmin', 'gestionnaire']);
    }

    /**
     * Vérifier si l'utilisateur peut gérer les stations
     */
    public function canManageStations(): bool
    {
        return $this->hasRole(['admin', 'superadmin']);
    }

    /**
     * Obtenir le nom du rôle formaté
     */
    public function getRoleNameAttribute(): string
    {
        return static::getAvailableRoles()[$this->role] ?? $this->role;
    }

    /**
     * Obtenir la couleur du rôle pour l'affichage
     */
    public function getRoleColorAttribute(): string
    {
        return match ($this->role) {
            'gestionnaire' => 'primary',
            'admin' => 'warning',
            'superadmin' => 'danger',
            default => 'gray',
        };
    }

    /**
     * Obtenir l'icône du rôle
     */
    public function getRoleIconAttribute(): string
    {
        return match ($this->role) {
            'gestionnaire' => 'heroicon-m-user-circle',
            'admin' => 'heroicon-m-shield-check',
            'superadmin' => 'heroicon-m-star',
            default => 'heroicon-m-user',
        };
    }

    /**
     * Scope pour filtrer les utilisateurs actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour filtrer par rôle
     */
    public function scopeByRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Obtenir le temps depuis la dernière connexion
     */
    public function getLastLoginHumanAttribute(): ?string
    {
        if (!$this->last_login_at) {
            return 'Jamais connecté';
        }

        return $this->last_login_at->diffForHumans();
    }

    /**
     * Relation avec les employés (si vous avez une table employees)
     */
  

    /**
     * Marquer la dernière connexion
     */
    public function markAsLoggedIn()
    {
        $this->update(['last_login_at' => now()]);
    }

    /**
     * Vérifier si l'utilisateur est en ligne (connecté dans les 5 dernières minutes)
     */
    public function getIsOnlineAttribute(): bool
    {
        if (!$this->last_login_at) {
            return false;
        }

        return $this->last_login_at->gt(now()->subMinutes(5));
    }

    /**
     * Obtenir les permissions basées sur le rôle
     */
    public function getPermissions(): array
    {
        return match ($this->role) {
            'superadmin' => [
                'manage_users',
                'manage_stations',
                'view_reports',
                'manage_employees',
                'system_settings',
                'create_admins',
            ],
            'admin' => [
                'manage_users',
                'manage_stations',
                'view_reports',
                'manage_employees',
            ],
            'gestionnaire' => [
                'view_reports',
                'manage_station_data',
            ],
            default => [],
        };
    }

    /**
     * Vérifier si l'utilisateur a une permission spécifique
     */
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->getPermissions());
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */



   
}