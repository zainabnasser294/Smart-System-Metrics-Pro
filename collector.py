import psutil
import requests
import time
import json


SERVER_IP = "localhost" 
API_URL = f"http://{SERVER_IP}/smart_monitor/api/receiver.php"
DEVICE_API_KEY = "1161dcba9e845cb7c0d22cdd0acdb3fd"

def collect_and_send():
    print(f"--- NBI Monitor: Active ---")
    
    
    last_net_io = psutil.net_io_counters()

    try:
        while True:
          
            cpu_usage = psutil.cpu_percent(interval=1)
            ram_usage = psutil.virtual_memory().percent
            
           
            current_net_io = psutil.net_io_counters()
          
            sent = current_net_io.bytes_sent - last_net_io.bytes_sent
            recv = current_net_io.bytes_recv - last_net_io.bytes_recv
            bandwidth = round((sent + recv) / (1024 * 1024), 2) 
            
            
            packets = (current_net_io.packets_sent - last_net_io.packets_sent) + \
                      (current_net_io.packets_recv - last_net_io.packets_recv)
            
            last_net_io = current_net_io 

            
            payload = {
                "api_key": DEVICE_API_KEY,
                "cpu_usage": cpu_usage,
                "ram_usage": ram_usage,
                "bandwidth_usage": bandwidth,
                "packet_count": packets
            }
            
            try:
                response = requests.post(API_URL, json=payload, timeout=5)
                if response.status_code == 200:
                    print(f"Sent -> CPU: {cpu_usage}% | Net: {bandwidth} Mbps | Packets: {packets}")
            except:
                print("Server connection failed...")
                
            time.sleep(3)
            
    except KeyboardInterrupt:
        print("\nStopped.")

if __name__ == "__main__":
    collect_and_send()