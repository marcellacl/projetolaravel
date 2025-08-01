<div class="mb-3">
    <label for="name" class="form-label">Nome</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $usuario->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="email" class="form-label">E-mail</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $usuario->email ?? '') }}" required>
</div>

@if(isset($usuario))
    <div class="mb-3 form-check">
        <input type="checkbox" name="blocked" class="form-check-input" id="blocked" {{ $usuario->blocked ? 'checked' : '' }}>
        <label class="form-check-label" for="blocked">Bloqueado</label>
    </div>
@endif

@if(!isset($usuario))
    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input type="password" name="password" class="form-control" required>
    </div>
@endif
