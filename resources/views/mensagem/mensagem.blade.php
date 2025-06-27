{{-- resources/views/mensagem/mensagem.blade.php --}}

@if(session('status'))
    <div class="alert alert-success" role="alert" id="alert-message">
        {{ session('status') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success" role="alert" id="alert-message">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" role="alert" id="alert-message">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger" role="alert" id="alert-message">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
    setTimeout(function () {
        let alert = document.getElementById('alert-message');
        if (alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 10000);
</script>
