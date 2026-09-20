<div class="modal fade" id="editAdminModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="background: rgba(30, 30, 30, 0.85); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-radius: 24px; border: 1px solid rgba(255, 255, 255, 0.08);">
            <div class="modal-header border-white border-opacity-10 px-4">
                <h5 class="modal-title text-white fw-bold">
                    <i class="bi bi-pencil-square text-info me-2"></i>{{ __('app.users-page-edit-modal-title') ?? 'Ulanyjyny Redaktirlemek' }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4 text-white text-start">
                    <div class="mb-3">
                        <label class="text-white-50 small fw-bold mb-2 text-uppercase">{{ __('app.users-page-create-modal-form-name') }}</label>
                        <input type="text" name="name" class="form-control bg-dark border-secondary text-white p-2" value="{{ $user->name }}" required style="border-radius: 12px;">
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50 small fw-bold mb-2 text-uppercase">{{ __('app.users-page-create-modal-form-username') }}</label>
                        <input type="text" name="username" class="form-control bg-dark border-secondary text-white p-2" value="{{ $user->username }}" required style="border-radius: 12px;">
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50 small fw-bold mb-2 text-uppercase">{{ __('app.users-page-create-modal-form-email') }}</label>
                        <input type="email" name="email" class="form-control bg-dark border-secondary text-white p-2" value="{{ $user->email }}" style="border-radius: 12px;">
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50 small fw-bold mb-2 text-uppercase">{{ __('app.users-page-create-modal-form-password') }} <span class="text-white-50 text-lowercase">(üýtgetmek islemeseňiz boş goşuň)</span></label>
                        <input type="password" name="password" class="form-control bg-dark border-secondary text-white p-2" placeholder="Täze parol..." style="border-radius: 12px;">
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50 small fw-bold mb-2 text-uppercase">{{ __('app.users-page-create-modal-form-role') }}</label>
                        <select name="role_id" class="form-select bg-dark border-secondary text-white p-2 dark-select" required style="border-radius: 12px;">
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                {{ $role->label }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-white border-opacity-10 px-4">
                    <button type="button" class="btn btn-link text-white-50 text-decoration-none fw-bold small" data-bs-dismiss="modal">
                        {{ __('app.users-page-btn-cancel') }}
                    </button>
                    <button type="submit" class="btn btn-info px-4 rounded-pill fw-bold shadow-sm">
                        {{ __('app.users-page-update-btn') ?? 'Ýatda sakla' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>