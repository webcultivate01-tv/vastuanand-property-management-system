<?php
namespace App\Core;

abstract class Controller
{
    protected Request $request;

    public function __construct() {
        $this->request = new Request();
    }

    protected function view(string $view, array $data = []): void {
        View::display($view, $data);
    }

    protected function json($data, int $status = 200): void {
        Response::json($data, $status);
    }

    protected function redirect(string $to, int $status = 302): void {
        Response::redirect($to, $status);
    }

    protected function back(): void {
        $ref = $_SERVER['HTTP_REFERER'] ?? '/';
        Response::redirect($ref);
    }

    protected function flash(string $key, $value): void {
        $_SESSION['_flash'][$key] = $value;
    }

    protected function input(string $key, $default = null) {
        return $this->request->input($key, $default);
    }

    protected function validate(array $rules, ?array $data = null): array
    {
        $data    = $data ?? $this->request->all();
        $errors  = [];
        $clean   = [];

        foreach ($rules as $field => $ruleStr) {
            $value = $data[$field] ?? null;
            foreach (explode('|', $ruleStr) as $rule) {
                [$name, $arg] = array_pad(explode(':', $rule, 2), 2, null);
                switch ($name) {
                    case 'required':
                        if ($value === null || $value === '' || $value === []) $errors[$field][] = "{$field} is required.";
                        break;
                    case 'email':
                        if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) $errors[$field][] = "{$field} must be a valid email.";
                        break;
                    case 'min':
                        if ($value !== null && mb_strlen((string)$value) < (int)$arg) $errors[$field][] = "{$field} must be at least {$arg} characters.";
                        break;
                    case 'max':
                        if ($value !== null && mb_strlen((string)$value) > (int)$arg) $errors[$field][] = "{$field} must be at most {$arg} characters.";
                        break;
                    case 'numeric':
                        if ($value !== null && !is_numeric($value)) $errors[$field][] = "{$field} must be numeric.";
                        break;
                    case 'in':
                        $allowed = explode(',', (string)$arg);
                        if ($value !== null && !in_array($value, $allowed, true)) $errors[$field][] = "{$field} is invalid.";
                        break;
                    case 'phone':
                        if ($value && !preg_match('/^\+?[0-9 \-]{8,15}$/', (string)$value)) $errors[$field][] = "{$field} is not a valid phone.";
                        break;
                }
            }
            $clean[$field] = is_string($value) ? trim($value) : $value;
        }

        if ($errors) {
            if ($this->request->isAjax()) {
                Response::json(['ok' => false, 'errors' => $errors], 422);
            }
            $_SESSION['_old']    = $data;
            $_SESSION['_errors'] = $errors;
            $this->back();
        }
        return $clean;
    }
}
