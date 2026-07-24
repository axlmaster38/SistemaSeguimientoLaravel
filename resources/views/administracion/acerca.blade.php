@extends('layouts.app')

@section('title', 'Información del Sistema | SME')

@section('content')
    <style>
        .system-info-page {
            --institutional-blue: #075b7a;
            --institutional-blue-dark: #075b7a;
        }

        .system-hero {
            background: linear-gradient(135deg, var(--institutional-blue), var(--institutional-blue-dark));
            border-radius: 1rem;
            box-shadow: 0 .85rem 2rem rgba(0, 47, 102, .16);
            margin-bottom: 1rem;
            padding: 1.5rem 2rem;
        }

        .system-hero-content {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 1.5rem;
        }

        .system-hero-logo-wrap {
            flex: 0 0 auto;
            width: auto;
        }

        .system-hero-logo {
            max-width: 180px;
            max-height: 155px;
            object-fit: contain;
            filter: drop-shadow(0 .45rem .85rem rgba(0, 0, 0, .18));
        }

        .system-hero-text {
            flex: 1 1 auto;
            min-width: 0;
            width: 100%;
        }

        .system-hero-title {
            width: 100%;
            font-size: clamp(1.55rem, 2vw, 1.95rem);
            line-height: 1.12;
            margin-bottom: .6rem;
        }

        .system-hero-university {
            font-size: 1.25rem;
            margin-bottom: .2rem;
        }

        .system-hero-school {
            color: rgba(255, 255, 255, .72);
            font-size: 1rem;
            margin-bottom: .65rem;
        }

        .system-hero-description {
            max-width: 950px;
            color: rgba(255, 255, 255, .78);
            font-size: .95rem;
            line-height: 1.45;
            margin-bottom: .75rem;
        }

        .system-version-badge {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, .94);
            color: var(--institutional-blue);
            padding: .4rem .8rem;
            font-size: .9rem;
            font-weight: 700;
            box-shadow: 0 .45rem 1rem rgba(0, 0, 0, .12);
        }

        .system-section-card {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 .7rem 1.55rem rgba(15, 23, 42, .08);
            overflow: hidden;
        }

        .system-section-title {
            background: var(--institutional-blue);
            color: #fff;
            font-size: .82rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .system-section-body {
            padding: 1.5rem;
        }

        .system-icon {
            width: 2.35rem;
            height: 2.35rem;
            flex: 0 0 2.35rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: .75rem;
            background: rgba(0, 63, 135, .1);
            color: var(--institutional-blue);
        }

        .system-footer-card {
            background: var(--institutional-blue);
            border-radius: 1rem;
            box-shadow: 0 .85rem 2rem rgba(0, 47, 102, .14);
        }

        .system-footer-card p {
            font-size: 1rem;
            line-height: 1.5;
        }

        @media (min-width: 1400px) {
            .system-hero-title {
                font-size: 1.8rem;
                white-space: nowrap;
            }
        }

        @media (max-width: 991.98px) {
            .system-hero {
                padding: 1.25rem;
                text-align: center;
            }

            .system-hero-content {
                flex-direction: column;
                gap: 1rem;
            }

            .system-hero-logo {
                max-width: 145px;
                max-height: 135px;
            }

            .system-hero-title,
            .system-hero-description {
                margin-left: auto;
                margin-right: auto;
                white-space: normal;
            }
        }

        @media (max-width: 575.98px) {
            .system-hero-logo {
                max-width: 120px;
                max-height: 115px;
            }
        }
    </style>

    <div class="system-info-page">
        <section class="system-hero text-white">
            <div class="system-hero-content">
                <div class="system-hero-logo-wrap">
                    <img
                        src="{{ asset('images/logo-unad3.png') }}"
                        alt="Logo UNAD"
                        class="img-fluid system-hero-logo"
                    >
                </div>
                <div class="system-hero-text">
                    <h1 class="system-hero-title fw-bold">
                        Sistema de Seguimiento y Monitoreo de Procesos Disciplinarios a Estudiantes
                    </h1>
                    <p class="system-hero-university fw-semibold">Universidad Nacional Abierta y a Distancia - UNAD</p>
                    <p class="system-hero-school">Escuela de Ciencias Básicas, Tecnología e Ingeniería (ECBTI)</p>
                    <p class="system-hero-description">
                        Sistema diseñado para apoyar la gestión, seguimiento y control de los procesos disciplinarios estudiantiles de la Universidad Nacional Abierta y a Distancia (UNAD).
                    </p>
                    <span class="system-version-badge">
                        <i class="fa-solid fa-code-branch"></i>
                        Versión 1.0
                    </span>
                </div>
            </div>
        </section>

        <div class="row g-3 g-xl-4">
            <div class="col-12 col-xl-6">
                <div class="card system-section-card h-100">
                    <div class="system-section-title px-4 py-3">Información general</div>
                    <div class="card-body system-section-body">
                        <div class="d-grid gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <span class="system-icon"><i class="fa-solid fa-code-branch"></i></span>
                                <div>
                                    <div class="text-muted small">Versión</div>
                                    <div class="fw-bold">1.0</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="system-icon"><i class="fa-solid fa-calendar-days"></i></span>
                                <div>
                                    <div class="text-muted small">Año</div>
                                    <div class="fw-bold">2026</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="system-icon"><i class="fa-solid fa-right-left"></i></span>
                                <div>
                                    <div class="text-muted small">Migración tecnológica</div>
                                    <div class="fw-bold">Django → Laravel</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <div class="card system-section-card h-100">
                    <div class="system-section-title px-4 py-3">Plataforma tecnológica</div>
                    <div class="card-body system-section-body">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center gap-3 h-100">
                                    <span class="system-icon"><i class="fa-brands fa-laravel"></i></span>
                                    <div>
                                        <div class="text-muted small">Framework</div>
                                        <div class="fw-bold">Laravel 12</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center gap-3 h-100">
                                    <span class="system-icon"><i class="fa-brands fa-php"></i></span>
                                    <div>
                                        <div class="text-muted small">PHP</div>
                                        <div class="fw-bold">8.4.16</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center gap-3 h-100">
                                    <span class="system-icon"><i class="fa-solid fa-server"></i></span>
                                    <div>
                                        <div class="text-muted small">Servidor Web</div>
                                        <div class="fw-bold">Apache 2.4.67</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center gap-3 h-100">
                                    <span class="system-icon"><i class="fa-solid fa-database"></i></span>
                                    <div>
                                        <div class="text-muted small">Base de Datos</div>
                                        <div class="fw-bold">MariaDB 11.8.6</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <div class="card system-section-card h-100">
                    <div class="system-section-title px-4 py-3">Institución</div>
                    <div class="card-body system-section-body">
                        <div class="d-grid gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <span class="system-icon"><i class="fa-solid fa-building-columns"></i></span>
                                <div>
                                    <div class="text-muted small">Universidad</div>
                                    <div class="fw-bold">Universidad Nacional Abierta y a Distancia</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="system-icon"><i class="fa-solid fa-school"></i></span>
                                <div>
                                    <div class="text-muted small">Escuela</div>
                                    <div class="fw-bold">ECBTI</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <div class="card system-section-card h-100">
                    <div class="system-section-title px-4 py-3">Desarrollo</div>
                    <div class="card-body system-section-body">
                        <div class="d-flex align-items-start gap-3">
                            <span class="system-icon"><i class="fa-solid fa-user-tie"></i></span>
                            <div>
                                <div class="text-muted small">Desarrollado por</div>
                                <div class="fw-bold fs-5">Alexander Torres Ramírez</div>
                                <div>Ingeniero de Sistemas</div>
                                <div class="text-muted">Universidad Nacional Abierta y a Distancia</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="system-footer-card text-white p-3 p-md-4 mt-3">
            <p class="mb-3">
                Este sistema fue desarrollado para apoyar la gestión, seguimiento y control de los procesos disciplinarios estudiantiles de la Universidad Nacional Abierta y a Distancia (UNAD), contribuyendo a una administración más eficiente, transparente y organizada.
            </p>
            <div class="border-top border-white border-opacity-25 pt-3 text-white-50 small">
                <div>© 2026 Universidad Nacional Abierta y a Distancia - UNAD</div>
                <div>Sistema de Seguimiento y Monitoreo de Procesos Disciplinarios a Estudiantes</div>
                <div>Versión 1.0</div>
            </div>
        </section>
    </div>
@endsection
