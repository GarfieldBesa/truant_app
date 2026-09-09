<?php
/**
 * Git Repository Cleanup — Truant Enterprises
 * Upload to public_html/git_fix.php
 * Visit: https://truantenterprises.com/git_fix.php
 * DELETE after use.
 *
 * Fixes: cPanel "Deploy HEAD Commit" disabled
 * Cause: Uncommitted changes in the server git repo
 */

$repoPath = '/home/uq7hadnu944q/repositories/truant_app';

function run(string $cmd): array {
    $output = ''; $code = -1;
    if (function_exists('exec')) {
        @exec($cmd . ' 2>&1', $lines, $code);
        $output = implode("\n", $lines);
    } elseif (function_exists('shell_exec')) {
        $output = (string)@shell_exec($cmd . ' 2>&1');
        $code = 0;
    } elseif (function_exists('passthru')) {
        ob_start(); @passthru($cmd . ' 2>&1', $code); $output = ob_get_clean();
    }
    return ['out' => trim($output), 'code' => $code];
}

$steps = [];

// 1. git status
$status = run("git -C " . escapeshellarg($repoPath) . " status --porcelain");
$steps[] = ['label' => 'git status --porcelain', 'result' => $status];

$isDirty = !empty(trim($status['out']));

// 2. If dirty, try git checkout -- .
if ($isDirty) {
    $reset = run("git -C " . escapeshellarg($repoPath) . " checkout -- .");
    $steps[] = ['label' => 'git checkout -- . (discard tracked changes)', 'result' => $reset];
}

// 3. git pull (Update from Remote)
$pull = run("git -C " . escapeshellarg($repoPath) . " pull origin main");
$steps[] = ['label' => 'git pull origin main', 'result' => $pull];

// 4. Check status again after
$statusAfter = run("git -C " . escapeshellarg($repoPath) . " status --porcelain");
$steps[] = ['label' => 'git status after fix', 'result' => $statusAfter];

// 5. Check if .cpanel.yml now exists
$cpanelYmlExists = file_exists($repoPath . '/.cpanel.yml');

// 6. Check git log to confirm latest commit
$log = run("git -C " . escapeshellarg($repoPath) . " log --oneline -3");
$steps[] = ['label' => 'git log --oneline -3', 'result' => $log];

$isClean = empty(trim($statusAfter['out']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Git Fix — Truant</title>
<style>
:root{--bg:#080f1e;--card:#0f1c2e;--border:#1e2f46;--green:#10b981;--red:#ef4444;--blue:#38bdf8;--yellow:#f59e0b;--gray:#94a3b8;--text:#f1f5f9}
*{box-sizing:border-box;margin:0;padding:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif}
body{background:var(--bg);color:var(--text);padding:30px 16px}
.wrap{max-width:760px;margin:0 auto;display:flex;flex-direction:column;gap:14px}
h1{font-size:20px;font-weight:700;color:#fff}
p.sub{font-size:13px;color:var(--gray);margin-top:4px}
.banner{border-radius:10px;padding:14px 18px;font-size:14px;font-weight:600}
.ok{background:rgba(16,185,129,.14);border:1px solid var(--green);color:#6ee7b7}
.fail{background:rgba(239,68,68,.12);border:1px solid var(--red);color:#fca5a5}
.warn{background:rgba(245,158,11,.12);border:1px solid var(--yellow);color:#fde68a}
.card{background:var(--card);border:1px solid var(--border);border-radius:10px;padding:14px 18px}
.card h3{font-size:13px;font-weight:600;color:var(--gray);margin-bottom:8px;text-transform:uppercase;letter-spacing:.5px}
pre{background:rgba(0,0,0,.5);padding:10px 14px;border-radius:6px;font-size:12px;line-height:1.6;color:#cbd5e1;white-space:pre-wrap;word-break:break-all}
.badge{display:inline-block;padding:2px 9px;border-radius:9999px;font-size:11px;font-weight:700}
.b-ok{background:rgba(16,185,129,.2);color:#34d399}
.b-fail{background:rgba(239,68,68,.2);color:#f87171}
.step{border-left:3px solid var(--border);padding-left:14px;margin-bottom:12px}
.step.s-ok{border-color:var(--green)}
.step.s-fail{border-color:var(--red)}
.step-label{font-size:12px;color:var(--gray);margin-bottom:5px}
code{background:rgba(0,0,0,.5);padding:2px 7px;border-radius:4px;font-family:ui-monospace,monospace;font-size:12px}
.terminal-box{background:#0a0f1a;border:1px solid var(--border);border-radius:8px;padding:16px 20px;font-family:ui-monospace,monospace;font-size:13px;color:#4ade80;line-height:1.8}
.terminal-box .prompt{color:#38bdf8}
a{color:var(--blue)}
</style>
</head>
<body>
<div class="wrap">

  <div>
    <h1>&#9881;&#65039; Git Repository Fix</h1>
    <p class="sub">Clears uncommitted changes + pulls latest commits to enable cPanel Deploy HEAD Commit.</p>
  </div>

  <!-- Overall Result -->
  <div class="banner <?= $isClean && $cpanelYmlExists ? 'ok' : ($isClean ? 'warn' : 'fail') ?>">
    <?php if ($isClean && $cpanelYmlExists): ?>
      &#9989; Git repo is clean and .cpanel.yml exists — go to cPanel and click <strong>Deploy HEAD Commit</strong>
    <?php elseif ($isClean): ?>
      &#9888; Repo is clean but .cpanel.yml is missing — click <strong>Update from Remote</strong> in cPanel first, then try again
    <?php else: ?>
      &#10060; Repo still has uncommitted changes — see manual fix below
    <?php endif ?>
  </div>

  <!-- Step Results -->
  <div class="card">
    <h3>Commands Run</h3>
    <?php foreach ($steps as $s):
        $ok = $s['result']['code'] === 0 || ($s['result']['code'] === -1 && $s['result']['out'] !== '');
        $hasOut = trim($s['result']['out']) !== '';
    ?>
      <div class="step <?= $ok ? 's-ok' : 's-fail' ?>">
        <div class="step-label">
          <code><?= htmlspecialchars($s['label']) ?></code>
          <span class="badge <?= $ok ? 'b-ok' : 'b-fail' ?>"><?= $ok ? 'OK' : 'Error / Blocked' ?></span>
        </div>
        <?php if ($hasOut): ?>
          <pre><?= htmlspecialchars($s['result']['out']) ?></pre>
        <?php else: ?>
          <pre style="color:var(--gray)">(no output)</pre>
        <?php endif ?>
      </div>
    <?php endforeach ?>
  </div>

  <!-- .cpanel.yml status -->
  <div class="card">
    <h3>.cpanel.yml Status</h3>
    <div style="display:flex;align-items:center;gap:10px;font-size:13px">
      <span class="badge <?= $cpanelYmlExists ? 'b-ok' : 'b-fail' ?>">
        <?= $cpanelYmlExists ? '✓ EXISTS' : '✗ MISSING' ?>
      </span>
      <span style="color:var(--gray)">
        <?= $cpanelYmlExists
            ? "Found at <code>{$repoPath}/.cpanel.yml</code> — cPanel can deploy"
            : "Not found — click \"Update from Remote\" in cPanel to pull it from GitHub" ?>
      </span>
    </div>
  </div>

  <!-- If exec() is blocked — manual steps via cPanel Terminal -->
  <?php if ($steps[0]['result']['code'] === -1 && empty($steps[0]['result']['out'])): ?>
  <div class="card">
    <h3>&#128196; exec() is disabled — Use cPanel Terminal Instead</h3>
    <p style="font-size:13px;color:var(--gray);margin-bottom:12px">
      PHP <code>exec()</code> is blocked on this server. Use the cPanel Terminal to run these commands manually:
    </p>
    <div class="terminal-box">
      <span class="prompt">$</span> git -C /home/uq7hadnu944q/repositories/truant_app checkout -- .<br>
      <span class="prompt">$</span> git -C /home/uq7hadnu944q/repositories/truant_app pull origin main<br>
      <span class="prompt">$</span> git -C /home/uq7hadnu944q/repositories/truant_app status
    </div>
    <p style="font-size:12px;color:var(--gray);margin-top:10px">
      cPanel Terminal: <strong>cPanel Home &rarr; Advanced &rarr; Terminal</strong>
    </p>
  </div>
  <?php endif ?>

  <!-- What to do in cPanel -->
  <div class="card">
    <h3>&#128203; cPanel Steps After This Fix</h3>
    <ol style="font-size:13px;color:#cbd5e1;line-height:2.2;margin-left:18px">
      <li>Go to <strong>cPanel &rarr; Git Version Control</strong></li>
      <li>Click <strong>"Update from Remote"</strong> — pulls latest commits including <code>.cpanel.yml</code></li>
      <li>Wait for it to complete, then refresh the page</li>
      <li>Click <strong>"Deploy HEAD Commit"</strong> — should now be enabled &#9989;</li>
    </ol>
  </div>

  <div style="background:rgba(239,68,68,.09);border:1px solid rgba(239,68,68,.35);border-radius:9px;padding:14px 17px;font-size:12px;color:#fca5a5">
    <strong>&#9888;&#65039; Security:</strong> Delete <code>public_html/git_fix.php</code> after use.
  </div>

</div>
</body>
</html>
