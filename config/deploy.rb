default_run_options[:pty] = true

# be sure to change these
set :user, 'git'
set :domain, 'github.com'
set :application, 'webco-basic'
set :wordpress_dir, 'webco-basic1'

# the rest should be good
set :repository,  "#{user}@#{domain}:git/#{application}.git"
set :deploy_to, "/home/#{user}/#{domain}"
set :deploy_via, :remote_cache
set :scm, 'git'
set :branch, 'master'
set :git_shallow_clone, 1
set :scm_verbose, true
set :use_sudo, false

server domain, :app, :web
role :db, domain, :primary => true

set :app_symlinks, ["wp-content/uploads"]
before  'deploy:update_code', 'wordpress:symlinks:setup'
after   'deploy:symlink', 'wordpress:symlinks:update'

namespace :wordpress do
  namespace :symlinks do
    desc "Setup application symlinks in the public"
    task :setup, :roles => [:web] do
      if app_symlinks
        app_symlinks.each { |link| run "mkdir -p #{shared_path}/public/#{wordpress_dir}/#{link}" }
      end
    end

    desc "Link public directories to shared location."
    task :update, :roles => [:web] do
      if app_symlinks
        app_symlinks.each { |link| run "ln -nfs #{shared_path}/public/#{wordpress_dir}/#{link} #{current_path}/public/#{wordpress_dir}/#{link}" }
      end
      send(run_method, "rm -f #{current_path}/public/#{wordpress_dir}/wp-config.php")
      send(run_method, "ln -nfs #{shared_path}/public/#{wordpress_dir}/wp-config.php #{current_path}/public/#{wordpress_dir}/wp-config.php")
    end
  end
end