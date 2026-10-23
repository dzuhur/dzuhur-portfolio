<?php

return [

    'name' => 'Dzuhur',
    'role' => 'IT & System Development Coordinator',
    'timezone' => 'Asia/Jakarta',

    'hero' => [
        'eyebrow' => 'Content × Technology',
        'lead' => 'Content creator turned',
        'subheadline' => 'An Informatics graduate who spent years telling brand stories, now building the systems behind them.',
    ],

        'seo' => [
        'title' => 'Dzuhur — Content Creator turned IT & System Development Coordinator',
        'description' => 'Dzuhur is a content creator turned IT & System Development Coordinator. Informatics graduate working at the intersection of content and technology.',
        // Path di folder public/, contoh: 'images/og-image.jpg'. Biarkan null sampai gambarnya siap.
        'og_image' => null,
    ],

        'about' => [
        "I studied Informatics, but my career started in video editing. Since 2021 I've worked in content creation — editing TikTok news videos, designing for Instagram, and eventually leading end-to-end content production for an F&B brand.",
        "That work taught me how stories are planned, produced, and measured. In 2026 I moved into an IT role at the same company, where I now coordinate system development, maintain the company website, and help kick off its customer mobile app.",
        "I'm still early in my developer journey — learning Laravel, PHP, and Flutter by building real things. This website is one of them.",
    ],

    'skills' => [
        [
            'group' => 'Content',
            'label' => 'Professional experience',
            'items' => [
                'Content Strategy', 'Content Planning', 'Scriptwriting', 'Video Production',
                'Video Editing', 'Social Media Management', 'Performance Reporting', 'Trend Research',
            ],
        ],
        [
            'group' => 'Creative',
            'label' => 'Professional experience',
            'items' => [
                'Storytelling', 'Visual Communication', 'Creative Direction',
                'Graphic Design', 'Photography & Videography',
            ],
        ],
        [
            'group' => 'Tech',
            'label' => 'Learning & building with',
            'items' => [
                'PHP', 'Laravel', 'MySQL', 'HTML', 'CSS', 'JavaScript', 'Flutter',
            ],
        ],
        [
            'group' => 'Tools',
            'label' => 'Tools I work with',
            'items' => [
                'Adobe After Effects', 'Adobe Photoshop', 'Vegas Pro', 'CapCut Pro',
                'CorelDRAW', 'Adobe XD', 'Figma', 'Canva Pro', 'Visual Studio Code',
            ],
        ],
    ],

        'experience' => [
        [
            'title' => 'IT & System Development Coordinator',
            'company' => 'PT Chikuro Indonesia Global',
            'period' => '2026 — Present',
            'points' => [
                'Audited existing digital and physical office assets and started a head office asset inventory for tracking',
                "Planned the development timeline for Chikuro's customer mobile app and kicked off the build",
                'Maintain and update the company website through its CMS',
            ],
        ],
        [
            'title' => 'Content Lead',
            'company' => 'PT Chikuro Indonesia Global',
            'period' => '2023 — 2026',
            'note' => 'Joined as Content Creator in 2023, promoted to Content Lead in 2025.',
            'points' => [
                'Led end-to-end content production, from planning to publishing',
                'Built content plans and scheduled production shoots',
                'Analyzed and reported content performance',
            ],
            'highlights' => [
                ['value' => '6K → 36K', 'label' => 'Instagram followers, 2023–2026'],
                ['value' => '900K', 'label' => 'views on a single video'],
            ],
        ],
        [
            'title' => 'Graphic Designer & Video Editor',
            'company' => 'Diferensia Foundation',
            'period' => '2022 — 2023',
            'points' => [
                "Designed graphic content for Diferensia's Instagram",
                'Produced video content end to end',
                'Provided content assets for the team',
                'Expanded interactive content formats as part of the content strategy',
            ],
        ],
        [
            'title' => 'TikTok Video Editor',
            'company' => 'PT Fix Digital Media',
            'period' => '2021 — 2022',
            'points' => [
                'Sourced news stories and edited them into TikTok videos for Fix Indonesia',
                'Built content plans for the TikTok channel',
                'Managed publishing',
            ],
        ],
    ],

    'education' => [
        [
            'degree' => 'Bachelor of Informatics Engineering',
            'school' => 'Universitas Islam Nusantara',
            'year' => '2023',
            'note' => 'Completed while working in content production.',
        ],
        [
            'degree' => 'Vocational High School, Software Engineering',
            'school' => 'SMK LPPM RI Bandung',
            'year' => '2015',
        ],
    ],

        'resume' => [
        'path' => 'resume.pdf',
        'download_name' => 'Dzuhur-Resume.pdf',
    ],

        'contact' => [
        'email' => 'dzuhur97@gmail.com',
        'socials' => [
            ['label' => 'Instagram', 'handle' => '@dzuhurrr', 'url' => 'https://www.instagram.com/dzuhurrr'],
            ['label' => 'LinkedIn', 'handle' => 'Muhammad Dzuhur', 'url' => 'https://www.linkedin.com/in/muhammad-dzuhur-3102091a4/'],
            ['label' => 'YouTube', 'handle' => '@dzuhurrr', 'url' => 'https://www.youtube.com/@dzuhurrr'],
        ],
    ],

];