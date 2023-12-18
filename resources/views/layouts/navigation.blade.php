<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="{{ route('profile.show') }}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        {{ __('Página Principal') }}
                    </p>
                </a>
            </li>

{{--            <li class="nav-item">--}}
{{--                <a href="{{ route('cliente.index') }}" class="nav-link">--}}
{{--                    <i class="nav-icon fas fa-users"></i>--}}
{{--                    <p>--}}
{{--                        Clientes--}}
{{--                    </p>--}}
{{--                </a>--}}
{{--            </li>--}}
            <li class="nav-item">
                <a href="{{ route('carro.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-car"></i>
                    <p>
                        Categorias
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('manutencao.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-wrench"></i>
                    <p>
                        Marcas
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('servico.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-clipboard-list"></i>

                    <p>
                        Fornecedores
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('servico.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-clipboard-list"></i>

                    <p>
                        Produtos
                    </p>
                </a>
            </li>

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
