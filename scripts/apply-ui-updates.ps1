$style = @'
    <style>
      :root {
        --color-primary: #1e1b4b;
        --color-action: #10b981;
        --color-urgent: #e11d48;
        --color-bg: #f8fafc;
      }
    </style>
'@

$mobileScript = @'
      // Mobile Sidebar Toggle Logic
      const menuBtn = document.querySelector('.mobile-menu-btn');
      const closeBtn = document.querySelector('.close-sidebar-btn');
      const sidebar = document.querySelector('aside');

      if (menuBtn && sidebar) {
        menuBtn.addEventListener('click', () => {
          sidebar.classList.remove('hidden');
          sidebar.classList.add('flex', 'fixed', 'inset-0', 'z-50', 'w-full');
        });
      }

      if (closeBtn && sidebar) {
        closeBtn.addEventListener('click', () => {
          sidebar.classList.add('hidden');
          sidebar.classList.remove('flex', 'fixed', 'inset-0', 'z-50', 'w-full');
        });
      }
'@

$mobileBrand = @'
              <div class="mb-2 flex items-center gap-3 lg:hidden">
                <img src="logo.png" alt="Mela Support Logo" class="h-10 w-auto" />
                <span class="text-sm font-semibold">Mela Support</span>
              </div>
'@

$menuButton = @'
            <button class="mobile-menu-btn lg:hidden rounded-2xl border border-slate-200/70 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
              <i data-lucide="menu" class="h-4 w-4"></i>
            </button>
'@

$links = @(
  @{ Key = 'index'; Href = 'index.html'; Icon = 'layout-dashboard'; Label = 'Landing' },
  @{ Key = 'register'; Href = 'register.html'; Icon = 'user-plus'; Label = 'Register' },
  @{ Key = 'login'; Href = 'login.html'; Icon = 'shield-check'; Label = 'Login' },
  @{ Key = 'dashboard'; Href = 'dashboard.html'; Icon = 'bar-chart-3'; Label = 'Dashboard' },
  @{ Key = 'create-ticket'; Href = 'create-ticket.html'; Icon = 'file-plus'; Label = 'Create Ticket' },
  @{ Key = 'ticket-details'; Href = 'ticket-details.html'; Icon = 'messages-square'; Label = 'Ticket Details' },
  @{ Key = 'agent-inbox'; Href = 'agent-inbox.html'; Icon = 'inbox'; Label = 'Agent Inbox' },
  @{ Key = 'agent-action'; Href = 'agent-action.html'; Icon = 'check-circle'; Label = 'Agent Action' },
  @{ Key = 'admin-analytics'; Href = 'admin-analytics.html'; Icon = 'line-chart'; Label = 'Admin Analytics' },
  @{ Key = 'settings'; Href = 'settings.html'; Icon = 'settings'; Label = 'Settings' }
)

Get-ChildItem -Path . -Filter *.html | ForEach-Object {
  $content = Get-Content -Raw $_.FullName

  if ($content -notmatch '--color-primary') {
    $content = $content -replace '(<script src="https://unpkg.com/lucide@latest"></script>)\s*</head>', "$1`n$style  </head>"
  }

  $content = $content -replace '</style>\s*</head>', "</style>`n  </head>"

  $activeKey = $_.BaseName
  $navItems = $links | ForEach-Object {
    $isActive = $_.Key -eq $activeKey
    $linkClass = if ($isActive) {
      'flex items-center gap-3 rounded-2xl px-4 py-3 bg-[var(--color-primary)] text-white'
    } else {
      'flex items-center gap-3 rounded-2xl px-4 py-3 text-slate-600 hover:bg-slate-100'
    }

    "          <a class=`"$linkClass`" href=`"$($_.Href)`">`n            <i data-lucide=`"$($_.Icon)`" class=`"h-4 w-4`"></i>`n            $($_.Label)`n          </a>"
  }

  $navHtml = $navItems -join "`n"
  $sidebarHtml = @"
      <aside class="hidden lg:flex w-72 flex-col border-r border-slate-200/70 bg-white/70 backdrop-blur-xl">
        <div class="p-6">
          <div class="flex items-center gap-3">
            <img src="logo.png" alt="Mela Support Logo" class="h-10 w-auto">
            <div>
              <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Mela Support</p>
              <p class="text-lg font-semibold">Digital Case Management</p>
            </div>
          </div>
        </div>
        <div class="px-6 lg:hidden">
          <button class="close-sidebar-btn inline-flex items-center gap-2 rounded-2xl border border-slate-200/70 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
            <i data-lucide="x" class="h-4 w-4"></i>
            Close
          </button>
        </div>
        <nav class="px-4 space-y-1 text-sm">
$navHtml
        </nav>
        <div class="mt-auto p-6">
          <div class="rounded-2xl border border-slate-200/70 bg-white/80 p-4 shadow-sm">
            <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Network</p>
            <p class="mt-2 text-sm font-medium">Addis Ababa Command Center</p>
            <p class="text-xs text-slate-500">Last sync 2 mins ago</p>
          </div>
        </div>
      </aside>
"@

  $content = $content -replace '(?s)<aside[^>]*class=[^>]*hidden lg:flex[^>]*>.*?</aside>', $sidebarHtml

  if ($content -notmatch 'mobile-menu-btn') {
    $content = $content -replace '(</div>\s*</header>)', "`n$menuButton`n          </div>`n        </header>"
  }

  if ($content -notmatch 'mb-2 flex items-center gap-3 lg:hidden') {
    $content = $content -replace '(<div>\s*)<p class="text-xs', "$1$mobileBrand              <p class=`"text-xs`""
  }

  $content = $content -replace '(<div class="flex flex-wrap[^>]*>\s*)(<div class="mb-2 flex items-center gap-3 lg:hidden">)', "$1<div>`n              $2"
  $content = $content -replace '(</h1>)\s*</div>\s*(<div class="flex items-center gap-3">)', "$1`n            </div>`n            $2"
  $content = $content -replace 'class="text-xs" uppercase', 'class="text-xs uppercase'
  $content = $content -replace 'text-\[var\(--color-primary\)\]xl', 'text-4xl'
  $content = $content -replace [regex]::Escape('`n'), "`n"


  if ($content -notmatch 'Mobile Sidebar Toggle Logic') {
    $content = $content -replace 'lucide.createIcons\(\);', "lucide.createIcons();`n$mobileScript"
  }

  $content = $content -replace 'bg-\[#10b981\]/15', 'bg-[color:var(--color-action)]/15'
  $content = $content -replace 'bg-\[#10b981\]', 'bg-[var(--color-action)]'
  $content = $content -replace 'text-\[#10b981\]', 'text-[var(--color-action)]'

  $content = $content -replace 'bg-\[#1e1b4b\]', 'bg-[var(--color-primary)]'
  $content = $content -replace 'text-\[#1e1b4b\]', 'text-[var(--color-primary)]'

  $content = $content -replace 'bg-\[#e11d48\]/15', 'bg-[color:var(--color-urgent)]/15'
  $content = $content -replace 'text-\[#e11d48\]', 'text-[var(--color-urgent)]'

  Set-Content -Path $_.FullName -Value $content
  Write-Host "Updated" $_.Name
}
