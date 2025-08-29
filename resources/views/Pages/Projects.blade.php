@extends('layouts.app')

@section('title', 'Lab')

@section('sidebar')
    @include('Components.Sidebar')
@endsection

@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --primary-dark: #00695C; /* Navbar and Footer: Deep teal */
            --primary-light: #4DB6AC; /* Sidebar: Lighter teal */
            --accent: #FF8A65; /* Titles and hover effects: Coral orange */
            --text-light: #E0F2F1; /* Text on dark backgrounds: Soft teal-white */
            --gradient-hover: linear-gradient(135deg, #4DB6AC, #00695C); /* Sidebar hover gradient */
            --background: #E6ECEC; /* Page background: Light teal-gray */
            --card-background: #FFFFFF; /* Project card background: Pure white */
            --card-border: #B2DFDB; /* Card border: Pale teal */
            --text-dark: #1A3C34; /* Main text: Dark teal-gray */
            --text-muted: #607D8B; /* Muted text for stats: Muted blue-gray */
            --shadow: rgba(0, 0, 0, 0.1); /* Shadow for cards and hover */
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background);
            color: var(--text-dark);
            line-height: 1.6;
            display: flex;
            margin: 0;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            width: 100%;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            margin: 2rem 0 1rem;
            color: var(--text-dark);
        }
        
        .search-bar {
            display: flex;
            align-items: center;
            background: var(--card-background);
            border: 1px solid var(--card-border);
            border-radius: 4px;
            margin-bottom: 1.5rem;
            width: 100%;
            max-width: 400px;
        }
        
        .search-bar input {
            flex: 1;
            border: none;
            padding: 0.8rem 1rem;
            background: transparent;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
        }
        
        .search-bar input:focus {
            outline: none;
        }
        
        .filter-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        
        .filter-btn {
            background: var(--card-background);
            border: 1px solid var(--card-border);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .filter-btn:hover, .filter-btn.active {
            background: var(--primary-dark);
            color: var(--text-light);
            border-color: var(--primary-dark);
        }
        
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            padding-bottom: 2rem;
        }
        
        .project-card {
            background: var(--card-background);
            overflow: hidden;
            box-shadow: 0 2px 4px var(--shadow);
            transition: transform 0.3s ease;
            max-height: 400px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .project-card:hover {
            transform: translateY(-5px);
        }
        
        .project-image {
            height: 150px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .project-title a {
            list-style: none;
            color: #00695C;
            text-decoration: none;
        }
        
        .project-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }
        
        .project-card:hover .project-image img {
            transform: scale(1.05);
        }
        
        .project-header {
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--card-border);
        }
        
        .project-category {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--card-border);
            padding: 0.3rem 0.8rem;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .project-category i {
            font-size: 1rem;
        }
        
        .project-price {
            background: var(--primary-dark);
            color: var(--text-light);
            padding: 0.3rem 0.8rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .project-content {
            padding: 1rem;
            flex-grow: 1;
        }
        
        .project-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }
        
        .project-desc {
            color: var(--text-muted);
            font-size: 0.9rem;
            line-height: 1.4;
        }
        
        .project-footer {
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid var(--card-border);
            min-height: 60px;
        }
        
        .project-stats {
            display: flex;
            gap: 1rem;
            color: var(--text-muted);
            font-size: 0.85rem;
        }
        
        .project-stats span {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }
        
        .download-btn {
            background: var(--primary-dark);
            color: var(--text-light);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            min-width: 100px;
            text-align: center;
        }
        
        .download-btn:hover {
            background: var(--primary-light);
        }
        
        .paid .download-btn {
            background: var(--accent);
        }
        
        .paid .download-btn:hover {
            background: #FF7043;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin: 2rem 0;
        }
        
        .page-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--card-border);
            background: var(--card-background);
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .page-btn:hover, .page-btn.active {
            background: var(--primary-dark);
            color: var(--text-light);
            border-color: var(--primary-dark);
        }
        
        @media (max-width: 1024px) {
            .container {
                width: 100%;
                padding: 0 0.5rem;
            }
            
            .projects-grid {
                grid-template-columns: 1fr;
            }
            
            .search-bar {
                max-width: 100%;
            }
        }

        .loading {
            text-align: center;
            padding: 2rem;
            font-size: 1.2rem;
            color: var(--text-muted);
        }
    </style>
@php
    $projectData = \App\Models\Project::where('status', 'active')->get();
@endphp
    <div class="container">
        <h1 class="page-title">Projects</h1>
        
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search">
        </div>
        
        <div class="filter-bar">
            <button class="filter-btn active">All Projects</button>
            <button class="filter-btn">Node.js</button>
            <button class="filter-btn">LaravelPHP</button>
            <button class="filter-btn">PHP</button>
            <button class="filter-btn">Free</button>
            <button class="filter-btn">Premium</button>
        </div>
        
        <div class="projects-grid" id="projects-container">
            @forelse ($projectData as $project)
                <div class="project-card {{ $project->price > 0 ? 'paid' : '' }}">
                    <div class="project-image">
                        <img src="{{ $project->image_url }}" alt="{{ $project->title }}">
                    </div>
                    <div class="project-header">
                        <div class="project-category">
                            <i class="fas fa-code"></i>
                            {{ $project->technology }}
                        </div>
                        <div class="project-price">
                            ${{ $project->price }}
                        </div>
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">
                            <a href="#">{{ $project->title }}</a>
                        </h3>
                        <p class="project-desc">
                            {{ $project->short_description }}
                        </p>
                    </div>
                    <div class="project-footer">
                        <div class="project-stats">
                            <span><i class="fas fa-download"></i> {{ $project->downloads }}</span>
                            <span><i class="fas fa-shopping-cart"></i> {{ $project->purchases }}</span>
                        </div>
                        <button class="download-btn">Download</button>
                    </div>
                </div>
            @empty
                <div class="loading">No projects found.</div>
            @endforelse
        </div>
        
        <div class="pagination">
            <button class="page-btn"><i class="fas fa-chevron-left"></i></button>
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>

@endsection