import SimpleHTTPServer
import SocketServer

def log_message(self, format, *args):
    return

PORT = 8000

Handler = SimpleHTTPServer.SimpleHTTPRequestHandler

httpd = SocketServer.TCPServer(("", PORT), Handler)
	
httpd.serve_forever()