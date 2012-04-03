set :application, "webco-basic"
set :repository, "git@github.com:playfield-media/webco-basic.git"
set :scm, :git
set :deploy_to, "/Users/Wiese/Desktop/test"

set :deploy_via, :remote_cache
set :copy_exclude, [".git", ".DS_Store", ".gitignore", ".gitmodules"]

server "example.org", :app