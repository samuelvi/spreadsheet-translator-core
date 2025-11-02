<?php

declare(strict_types=1);

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Atico\SpreadsheetTranslator\Core\Tests\Fixtures\data;

class SampleData
{
    public static function getSimpleTranslationData(): array
    {
        return [
            ['key', 'es', 'en'],
            ['welcome', 'Bienvenido', 'Welcome'],
            ['goodbye', 'Adiós', 'Goodbye'],
            ['hello', 'Hola', 'Hello'],
        ];
    }

    public static function getMultiKeyTranslationData(): array
    {
        return [
            ['module', 'key', 'es', 'en', 'fr'],
            ['user', 'name', 'Nombre', 'Name', 'Nom'],
            ['user', 'email', 'Correo electrónico', 'Email', 'Courriel'],
            ['user', 'password', 'Contraseña', 'Password', 'Mot de passe'],
            ['button', 'submit', 'Enviar', 'Submit', 'Soumettre'],
            ['button', 'cancel', 'Cancelar', 'Cancel', 'Annuler'],
            ['message', 'success', 'Operación exitosa', 'Successful operation', 'Opération réussie'],
        ];
    }

    public static function getDataWithRegionalLocales(): array
    {
        return [
            ['key', 'es_ES', 'es_MX', 'en_US', 'en_GB'],
            ['color', 'Color', 'Color', 'Color', 'Colour'],
            ['center', 'Centro', 'Centro', 'Center', 'Centre'],
        ];
    }

    public static function getDataWithEmptyValues(): array
    {
        return [
            ['key', 'es', 'en'],
            ['greeting', 'Hola', 'Hello'],
            ['empty', '', ''],
            ['partial', 'Texto', ''],
        ];
    }

    public static function getDataWithLazyKeys(): array
    {
        return [
            ['section', 'key', 'es', 'en'],
            ['user', 'name', 'Nombre', 'Name'],
            ['', 'email', 'Correo', 'Email'], // Lazy key - should use 'user'
            ['', 'password', 'Contraseña', 'Password'], // Lazy key - should use 'user'
            ['admin', 'role', 'Rol', 'Role'],
        ];
    }

    public static function getComplexNestedData(): array
    {
        return [
            ['module', 'section', 'subsection', 'key', 'es', 'en'],
            ['app', 'auth', 'login', 'title', 'Iniciar sesión', 'Login'],
            ['app', 'auth', 'login', 'username', 'Usuario', 'Username'],
            ['app', 'auth', 'login', 'password', 'Contraseña', 'Password'],
            ['app', 'auth', 'register', 'title', 'Registrarse', 'Register'],
            ['app', 'auth', 'register', 'confirm', 'Confirmar contraseña', 'Confirm password'],
            ['app', 'profile', 'settings', 'title', 'Configuración', 'Settings'],
        ];
    }

    public static function getDataWithSpecialCharacters(): array
    {
        return [
            ['key', 'es', 'en'],
            ['special.chars', 'Caracteres especiales: ñáéíóú', 'Special chars: test'],
            ['quotes', 'Texto con "comillas"', 'Text with "quotes"'],
            ['apostrophe', "L'apostrophe", "The apostrophe"],
        ];
    }

    public static function getEmptyDataset(): array
    {
        return [
            ['key', 'es', 'en'],
        ];
    }

    public static function getSampleConfiguration(): array
    {
        return [
            'translations' => [
                'provider' => [
                    'name' => 'matrix',
                    'format' => 'matrix',
                ],
                'parser' => [
                    'row_header' => 0,
                    'first_row' => 0,
                    'name_separator' => '.',
                ],
                'exporter' => [
                    'format' => 'yml',
                    'path' => sys_get_temp_dir() . '/translations',
                    'locales_dir_name' => '',
                    'domains_dir_name' => '',
                ],
            ],
        ];
    }
}
