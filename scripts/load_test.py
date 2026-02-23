import asyncio
import time
import aiohttp
import random

# Configuration
BASE_URL = "http://localhost:8000"  # Change this to the deployed URL if needed
NUM_USERS = 500
DURATION = 30  # seconds

# Endpoints to test
ENDPOINTS = [
    "/",
    "/evren",
    "/arena",
    "/izleyici",
    "/sura/login",
]

async def fetch(session, url):
    start_time = time.time()
    try:
        async with session.get(url) as response:
            await response.text()
            end_time = time.time()
            return response.status, end_time - start_time
    except Exception as e:
        return 0, 0

async def user_behavior(session):
    # Simulate a user browsing
    # 1. Visit Home
    status, latency = await fetch(session, BASE_URL + "/")
    if status != 200: return ("/", status, latency)
    
    # 2. Randomly visit another page
    page = random.choice(ENDPOINTS)
    status, latency = await fetch(session, BASE_URL + page)
    return (page, status, latency)

async def run_load_test():
    print(f"Starting load test with {NUM_USERS} users for {DURATION} seconds...")
    
    async with aiohttp.ClientSession() as session:
        tasks = []
        start_global = time.time()
        
        # Ramp up users
        for i in range(NUM_USERS):
            tasks.append(user_behavior(session))
            if (i + 1) % 50 == 0:
                print(f"Spawned {i + 1} users...")
                await asyncio.sleep(0.05) # Gentle ramp up
        
        results = await asyncio.gather(*tasks)
        
        end_global = time.time()
        
        # Analyze results
        success_count = sum(1 for r in results if r[1] == 200)
        fail_count = sum(1 for r in results if r[1] != 200)
        total_time = end_global - start_global
        avg_latency = sum(r[2] for r in results) / len(results) if results else 0
        
        print("\n--- Load Test Results ---")
        print(f"Total Requests: {len(results)}")
        print(f"Success: {success_count}")
        print(f"Failed: {fail_count}")
        print(f"Total Time: {total_time:.2f}s")
        if total_time > 0:
            print(f"Requests Per Second: {len(results) / total_time:.2f}")
        else:
            print("Requests Per Second: N/A")
        print(f"Average Latency: {avg_latency:.4f}s")

if __name__ == "__main__":
    # Check if aiohttp is installed
    try:
        import aiohttp
        asyncio.run(run_load_test())
    except ImportError:
        print("Error: aiohttp is not installed. Please install it to run this test.")
